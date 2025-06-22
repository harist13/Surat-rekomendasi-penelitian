<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\NonMahasiswa;
use App\Models\PenerbitanSurat;
use App\Models\Notifikasi;
use App\Models\StatusHistory;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use Carbon\Carbon;
use PDF;

class StaffController extends Controller
{ 
    /**
     * Get notifications for new applications
     */
    private function getNewApplicationNotifications()
    {
        $newApplicationNotifications = Notifikasi::where(function($query) {
                $query->where('judul', 'like', '%Pengajuan Baru%')
                      ->orWhere('pesan', 'like', '%pengajuan baru%')
                      ->orWhere('pesan', 'like', '%mengirimkan pengajuan%');
            })
            ->where(function($query) {
                // Exclude verification and surat-related notifications
                $query->whereNull('penerbitan_surat_id')
                    ->whereNull('alasan_penolakan');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return $newApplicationNotifications;
    }

    /**
     * Get notifications related to verification (approval/rejection)
     */
    private function getVerificationNotifications()
    {
        $verificationNotifications = Notifikasi::where(function($query) {
                // Verification related notifications
                $query->where('tipe', 'success')
                    ->orWhere('tipe', 'danger')
                    ->orWhere('pesan', 'like', '%diterima%')
                    ->orWhere('pesan', 'like', '%ditolak%')
                    ->orWhereNotNull('alasan_penolakan');
            })
            ->where(function($query) {
                // But exclude surat-related notifications
                $query->whereNull('penerbitan_surat_id')
                    ->where('judul', 'not like', '%Surat%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return $verificationNotifications;
    }

    /**
     * Get surat-related notifications
     */
    private function getSuratNotifications()
    {
        $suratNotifications = Notifikasi::where(function($query) {
                // Look for notifications with specific titles related to surat
                $query->where('judul', 'like', '%Surat%')
                      ->orWhere('pesan', 'like', '%surat%')
                      ->orWhere('pesan', 'like', '%diterbitkan%');
            })
            ->orWhere(function($query) {
                // Include all notifications with penerbitan_surat_id
                $query->whereNotNull('penerbitan_surat_id');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return $suratNotifications;
    }

    /**
     * Get all unread notifications (for the counter badge)
     */
    private function getUnreadNotifications()
    {
        $unreadNotifications = Notifikasi::where('telah_dibaca', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return $unreadNotifications;
    }

    public function index()
    {
        // Count total users
        $totalUsers = User::count();
        
        // Count pending requests (both mahasiswa and non-mahasiswa)
        $pendingMahasiswa = Mahasiswa::whereNotIn('status', ['diterima', 'ditolak'])->count();
        $pendingNonMahasiswa = NonMahasiswa::whereNotIn('status', ['diterima', 'ditolak'])->count();
        $totalPending = $pendingMahasiswa + $pendingNonMahasiswa;
        
        // Count approved documents (surat yang diterbitkan)
        $approvedDocuments = PenerbitanSurat::where('status_surat', 'diterbitkan')->count();
        
        // Count accepted documents (pengajuan yang diterima)
        $acceptedMahasiswa = Mahasiswa::where('status', 'diterima')->count();
        $acceptedNonMahasiswa = NonMahasiswa::where('status', 'diterima')->count();
        $acceptedDocuments = $acceptedMahasiswa + $acceptedNonMahasiswa;
        
        // Count rejected documents (pengajuan yang ditolak)
        $rejectedMahasiswa = Mahasiswa::where('status', 'ditolak')->count();
        $rejectedNonMahasiswa = NonMahasiswa::where('status', 'ditolak')->count();
        $rejectedDocuments = $rejectedMahasiswa + $rejectedNonMahasiswa;
        
        // Get monthly statistics for chart
        $monthlyStats = $this->getMonthlyStatistics();
        
        // Get notifications
        $unreadNotifications = $this->getUnreadNotifications();
        $newApplicationNotifications = $this->getNewApplicationNotifications();
        $verificationNotifications = $this->getVerificationNotifications();
        $suratNotifications = $this->getSuratNotifications();
        
        return view('staff.index', compact(
            'totalUsers', 
            'totalPending', 
            'approvedDocuments',
            'acceptedDocuments',
            'rejectedDocuments', 
            'monthlyStats',
            'unreadNotifications',
            'newApplicationNotifications',
            'verificationNotifications',
            'suratNotifications'
        ));
    }
    
    /**
     * Get monthly statistics for the dashboard chart
     */
    private function getMonthlyStatistics()
    {
        // Get data for the last 6 months
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subMonths(5)->startOfMonth();
        
        $months = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate->lte($endDate)) {
            $months[] = $currentDate->format('M Y');
            $currentDate->addMonth();
        }
        
        // Initialize statistics arrays
        $userStats = [];
        $requestStats = [];
        $documentStats = [];
        $acceptedStats = []; // Stats untuk dokumen diterima
        $rejectedStats = []; // Stats untuk dokumen ditolak
        
        // For each month, get the counts
        foreach ($months as $index => $month) {
            $monthStart = $startDate->copy()->addMonths($index)->startOfMonth();
            $monthEnd = $startDate->copy()->addMonths($index)->endOfMonth();
            
            // Users created in this month
            $userStats[] = User::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            
            // Requests created in this month (both types)
            $mahasiswaRequests = Mahasiswa::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $nonMahasiswaRequests = NonMahasiswa::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $requestStats[] = $mahasiswaRequests + $nonMahasiswaRequests;
            
            // Documents published in this month
            $documentStats[] = PenerbitanSurat::where('status_surat', 'diterbitkan')
                            ->whereBetween('created_at', [$monthStart, $monthEnd])
                            ->count();
                            
            // Accepted documents in this month
            $mahasiswaAccepted = Mahasiswa::where('status', 'diterima')
                            ->whereBetween('updated_at', [$monthStart, $monthEnd])
                            ->count();
            $nonMahasiswaAccepted = NonMahasiswa::where('status', 'diterima')
                            ->whereBetween('updated_at', [$monthStart, $monthEnd])
                            ->count();
            $acceptedStats[] = $mahasiswaAccepted + $nonMahasiswaAccepted;
            
            // Rejected documents in this month
            $mahasiswaRejected = Mahasiswa::where('status', 'ditolak')
                            ->whereBetween('updated_at', [$monthStart, $monthEnd])
                            ->count();
            $nonMahasiswaRejected = NonMahasiswa::where('status', 'ditolak')
                             ->whereBetween('updated_at', [$monthStart, $monthEnd])
                             ->count();
            $rejectedStats[] = $mahasiswaRejected + $nonMahasiswaRejected;
        }
        
        return [
            'months' => $months,
            'userStats' => $userStats,
            'requestStats' => $requestStats,
            'documentStats' => $documentStats,
            'acceptedStats' => $acceptedStats, // Tambahkan data dokumen diterima
            'rejectedStats' => $rejectedStats // Tambahkan data dokumen ditolak
        ];
    }

    public function penerbitan()
    {
        $approvedMahasiswa = Mahasiswa::where('status', 'diterima')->get();
        $approvedNonMahasiswa = NonMahasiswa::where('status', 'diterima')->get();
        
        // Get notifications for the layout
        $unreadNotifications = $this->getUnreadNotifications();
        $newApplicationNotifications = $this->getNewApplicationNotifications();
        $verificationNotifications = $this->getVerificationNotifications();
        $suratNotifications = $this->getSuratNotifications();
        
        return view('staff.penerbitan', compact(
            'approvedMahasiswa', 
            'approvedNonMahasiswa',
            'unreadNotifications',
            'newApplicationNotifications',
            'verificationNotifications',
            'suratNotifications'
        ));
    }

    public function getMahasiswaData(Request $request)
    {
        $id = $request->input('id');
        $mahasiswa = Mahasiswa::findOrFail($id);
        
        return response()->json($mahasiswa);
    }

    public function getNonMahasiswaData(Request $request)
    {
        $id = $request->input('id');
        $nonMahasiswa = NonMahasiswa::findOrFail($id);
        
        return response()->json($nonMahasiswa);
    }

    public function storePenerbitan(Request $request)
    {
        // Start database transaction
        DB::beginTransaction();
        
        try {
            // Validate the form input
            $validatedData = $request->validate([
                'jenis_surat' => 'required|in:mahasiswa,non_mahasiswa',
                'pemohon_id' => 'required',
                'nomor_surat' => 'required|string',
                'menimbang' => 'required|string',
                'tembusan' => 'required|string',
                'status_penelitian' => 'required|in:baru,lama,perpanjangan',
                'status_surat' => 'required|string',
                // Remove no_pengajuan from validation as it's only for display
            ], [
                'jenis_surat.required' => 'Jenis surat harus dipilih',
                'jenis_surat.in' => 'Jenis surat tidak valid',
                'pemohon_id.required' => 'Pemohon harus dipilih',
                'nomor_surat.required' => 'Nomor surat harus diisi',
                'status_penelitian.required' => 'Status penelitian harus dipilih',
                'status_penelitian.in' => 'Status penelitian tidak valid',
                'status_surat.required' => 'Status surat harus diisi',
            ]);

            // Check for duplicate entries
            if ($validatedData['jenis_surat'] === 'mahasiswa') {
                $existingLetter = PenerbitanSurat::where('jenis_surat', 'mahasiswa')
                    ->where('mahasiswa_id', $validatedData['pemohon_id'])
                    ->first();
                
                if ($existingLetter) {
                    DB::rollBack(); // Roll back transaction
                    $mahasiswa = Mahasiswa::findOrFail($validatedData['pemohon_id']);
                    return redirect()->back()->with('error', 'Surat untuk mahasiswa "' . $mahasiswa->nama_lengkap . '" sudah pernah diterbitkan dengan nomor ' . $existingLetter->nomor_surat . '. Silakan periksa kembali data surat yang ada.')->withInput();
                }
            } else { // non_mahasiswa
                $existingLetter = PenerbitanSurat::where('jenis_surat', 'non_mahasiswa')
                    ->where('non_mahasiswa_id', $validatedData['pemohon_id'])
                    ->first();
                
                if ($existingLetter) {
                    DB::rollBack(); // Roll back transaction
                    $nonMahasiswa = NonMahasiswa::findOrFail($validatedData['pemohon_id']);
                    return redirect()->back()->with('error', 'Surat untuk non-mahasiswa "' . $nonMahasiswa->nama_lengkap . '" sudah pernah diterbitkan dengan nomor ' . $existingLetter->nomor_surat . '. Silakan periksa kembali data surat yang ada.')->withInput();
                }
            }

            // Create new PenerbitanSurat record
            $penerbitanSurat = new PenerbitanSurat();
            $penerbitanSurat->jenis_surat = $validatedData['jenis_surat'];
            $penerbitanSurat->nomor_surat = $validatedData['nomor_surat'];
            $penerbitanSurat->menimbang = $validatedData['menimbang'] ?? null;
            $penerbitanSurat->tembusan = $validatedData['tembusan'] ?? null;
            $penerbitanSurat->status_penelitian = $validatedData['status_penelitian'];
            $penerbitanSurat->status_surat = $validatedData['status_surat'];
            $penerbitanSurat->user_id = auth()->id();
            // Remove the line that tries to save no_pengajuan

            // Associate with either mahasiswa or non_mahasiswa based on jenis
            $peneliti = null;
            
            if ($validatedData['jenis_surat'] === 'mahasiswa') {
                $penerbitanSurat->mahasiswa_id = $validatedData['pemohon_id'];
                $penerbitanSurat->non_mahasiswa_id = null;
                $peneliti = Mahasiswa::findOrFail($validatedData['pemohon_id']);
                
                // Add status history entry
                $this->addStatusHistory(
                    'mahasiswa', 
                    $validatedData['pemohon_id'], 
                    'surat_dibuat', 
                    'Surat penelitian telah dibuat dengan nomor ' . $validatedData['nomor_surat'] . ' dan sedang menunggu tanda tangan kepala bidang kewaspadaan nasional dan penanganan konflik'
                );
            } else {
                $penerbitanSurat->non_mahasiswa_id = $validatedData['pemohon_id'];
                $penerbitanSurat->mahasiswa_id = null;
                $peneliti = NonMahasiswa::findOrFail($validatedData['pemohon_id']);
                
                // Add status history entry
                $this->addStatusHistory(
                    'non_mahasiswa', 
                    $validatedData['pemohon_id'], 
                    'surat_dibuat', 
                    'Surat penelitian telah dibuat dengan nomor ' . $validatedData['nomor_surat'] . ' dan sedang menunggu tanda tangan kepala bidang kewaspadaan nasional dan penanganan konflik'
                );
            }

            $penerbitanSurat->save();
            
            // Generate Word document
            $documentPath = $this->generateSuratPenelitian($penerbitanSurat->id);
            
            // Store the document path in the session
            session(['generated_document' => $documentPath]);

            // Commit transaction if we reach this point (everything successful)
            DB::commit();

            // Create notification for surat creation
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Surat Penelitian Dibuat';
            $notifikasi->pesan = 'Surat penelitian telah dibuat dengan nomor ' . $validatedData['nomor_surat'];
            $notifikasi->tipe = 'info';
            $notifikasi->tipe_peneliti = $validatedData['jenis_surat'];
            $notifikasi->user_id = auth()->id();
            
            if ($validatedData['jenis_surat'] === 'mahasiswa') {
                $notifikasi->mahasiswa_id = $validatedData['pemohon_id'];
                $notifikasi->non_mahasiswa_id = null;
            } else {
                $notifikasi->mahasiswa_id = null;
                $notifikasi->non_mahasiswa_id = $validatedData['pemohon_id'];
            }
            
            // Save the notification after the penerbitan_surat is created to get its ID
            $notifikasi->penerbitan_surat_id = $penerbitanSurat->id;
            $notifikasi->save();
            
            return redirect()->route('datasurat')->with([
                'success' => 'Data surat berhasil dibuat',
                'document_path' => $documentPath
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Roll back transaction
            DB::rollBack();
            
            // Handle validation errors
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            // Roll back transaction
            DB::rollBack();
            
            // Handle database errors
            $errorCode = $e->errorInfo[1] ?? '';
            
            if ($errorCode == 1062) {
                // Duplicate entry
                return redirect()->back()->with('error', 'Nomor surat sudah digunakan. Silahkan gunakan nomor surat yang lain.')->withInput();
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan database: ' . $e->getMessage())->withInput();
        } catch (\Exception $e) {
            // Roll back transaction
            DB::rollBack();
            
            // Handle general errors
            return redirect()->back()->with('error', 'Gagal menerbitkan surat: ' . $e->getMessage())->withInput();
        }
    }

     /**
     * Generate a Word document for Surat Keterangan Penelitian
     * 
     * @param int $suratId
     * @return string Path to the generated document
     */
     private function generateSuratPenelitian($suratId)
    {
        // Ambil data surat dan relasi terkait
        $surat = PenerbitanSurat::with(['mahasiswa', 'nonMahasiswa', 'user'])->findOrFail($suratId);

        // Penentuan data berdasarkan jenis surat
        if ($surat->jenis_surat === 'mahasiswa') {
            $peneliti = $surat->mahasiswa;
            $jabatan = 'Mahasiswa';
            $nimFormatted = ' / NIM. ' . $peneliti->nim;
            $bidang = $peneliti->jurusan;
        } else {
            $peneliti = $surat->nonMahasiswa;
            $jabatan = $peneliti->jabatan;
            $nimFormatted = ''; // Hapus NIM jika non-mahasiswa
            $bidang = $peneliti->bidang;
        }

        // Format tanggal
        $tanggalSurat = Carbon::now()->locale('id')->isoFormat('D MMMM Y');
        $tanggalMulai = Carbon::parse($peneliti->tanggal_mulai)->locale('id')->translatedFormat('d-M-Y');
        $tanggalSelesai = Carbon::parse($peneliti->tanggal_selesai)->locale('id')->translatedFormat('d-M-Y');
        $waktuPenelitian = $tanggalMulai . ' s.d ' . $tanggalSelesai;


        // Proses anggota peneliti
        $anggotaText = '';
        if (!empty($peneliti->anggota_peneliti)) {
            try {
                $anggota = json_decode($peneliti->anggota_peneliti);
                if (is_array($anggota)) {
                    foreach ($anggota as $index => $nama) {
                        $anggotaText .= ($index + 1) . '. ' . $nama . "\n";
                    }
                } else {
                    $anggotaText = $peneliti->anggota_peneliti;
                }
            } catch (\Exception $e) {
                $anggotaText = $peneliti->anggota_peneliti;
            }
        }

        // Path ke template Word
        $templatePath = public_path('assets/surat_template.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        // Isi data ke template
        $templateProcessor->setValues([
            'nomor_surat' => $surat->nomor_surat,
            'menimbang' => $surat->menimbang,
            'tembusan' => $surat->tembusan,
            'nama_lengkap' => $peneliti->nama_lengkap,
            'jabatan' => $jabatan,
            'nim' => $nimFormatted,
            'no_hp' => $peneliti->no_hp,
            'alamat_peneliti' => $peneliti->alamat_peneliti,
            'nama_instansi' => $peneliti->nama_instansi,
            'alamat_instansi' => $peneliti->alamat_instansi,
            'judul_penelitian' => $peneliti->judul_penelitian,
            'bidang' => $bidang,
            'status_penelitian' => $surat->status_penelitian,
            'anggota_peneliti' => $anggotaText,
            'lokasi_penelitian' => $peneliti->lokasi_penelitian,
            'waktu_penelitian' => $waktuPenelitian,
            'tujuan_penelitian' => $peneliti->tujuan_penelitian,
        ]);

        // Buat folder jika belum ada
        $directory = storage_path('app/public/documents/surat_penelitian');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $nomorSuratSafe = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $surat->nomor_surat);

        // Simpan file Word
        $fileName = 'surat_penelitian_' . $nomorSuratSafe . '_' . time() . '.docx';
        $filePath = $directory . '/' . $fileName;
        $templateProcessor->saveAs($filePath);

        // Return path relatif untuk disimpan di DB atau digunakan di frontend
        return 'documents/surat_penelitian/' . $fileName;
    }

    /**
     * Download the generated document
     * 
     * @param string $fileName
     * @return \Illuminate\Http\Response
     */
    public function downloadDocument($id)
    {
        try {
            $surat = PenerbitanSurat::findOrFail($id);
            
            // Generate a new document or use the stored one
            $filePath = $this->generateSuratPenelitian($id);
            
            // Prepare the file for download
            $fileName = basename($filePath);
            
            // Return the file as a download
            return Storage::download('public/' . $filePath, $fileName);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunduh dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Update surat dengan file yang diunggah
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateSuratFile(Request $request, $id)
    {
        try {
            // Validasi request
            $request->validate([
                'file_surat' => 'required|file|mimes:doc,docx,pdf|max:5120', // Max 5MB
            ], [
                'file_surat.required' => 'File surat harus diunggah',
                'file_surat.file' => 'Upload harus berupa file',
                'file_surat.mimes' => 'Format file harus doc, docx, atau pdf',
                'file_surat.max' => 'Ukuran file maksimal 5MB',
            ]);

            // Ambil data surat
            $surat = PenerbitanSurat::findOrFail($id);
            
            // Upload file
            if ($request->hasFile('file_surat')) {
                // Tentukan direktori penyimpanan
                $directory = 'documents/surat_penelitian';
                
                // Pastikan direktori ada
                if (!file_exists(public_path('storage/' . $directory))) {
                    mkdir(public_path('storage/' . $directory), 0777, true);
                }
                
                // Simpan file
                $file = $request->file('file_surat');
                $fileName = 'surat_penelitian_' . $surat->nomor_surat . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Gunakan move untuk menghindari masalah izin
                $file->move(public_path('storage/' . $directory), $fileName);
                $filePath = $directory . '/' . $fileName;
                
                // Simpan path file ke database
                $surat->file_path = $filePath;
                $surat->save();
                
                // Add status history entry
                if ($surat->mahasiswa_id) {
                    $this->addStatusHistory(
                        'mahasiswa', 
                        $surat->mahasiswa_id, 
                        'surat_diupdate', 
                        'File surat dengan nomor ' . $surat->nomor_surat . ' telah diperbarui'
                    );

                    // Create notification for surat update
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Surat Penelitian Diperbarui';
                    $notifikasi->pesan = 'File surat penelitian dengan nomor ' . $surat->nomor_surat . ' telah diperbarui';
                    $notifikasi->tipe = 'info';
                    $notifikasi->tipe_peneliti = 'mahasiswa';
                    $notifikasi->mahasiswa_id = $surat->mahasiswa_id;
                    $notifikasi->user_id = auth()->id();
                    $notifikasi->penerbitan_surat_id = $surat->id;
                    $notifikasi->save();
                } else {
                    $this->addStatusHistory(
                        'non_mahasiswa', 
                        $surat->non_mahasiswa_id, 
                        'surat_diupdate', 
                        'File surat dengan nomor ' . $surat->nomor_surat . ' telah diperbarui'
                    );

                    // Create notification for surat update
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Surat Penelitian Diperbarui';
                    $notifikasi->pesan = 'File surat penelitian dengan nomor ' . $surat->nomor_surat . ' telah diperbarui';
                    $notifikasi->tipe = 'info';
                    $notifikasi->tipe_peneliti = 'non_mahasiswa';
                    $notifikasi->non_mahasiswa_id = $surat->non_mahasiswa_id;
                    $notifikasi->user_id = auth()->id();
                    $notifikasi->penerbitan_surat_id = $surat->id;
                    $notifikasi->save();
                }
                
                return redirect()->route('datasurat')->with('success', 'File surat berhasil diperbarui');
            }
            
            return redirect()->route('datasurat')->with('error', 'Tidak ada file yang diunggah');
        } catch (\Exception $e) {
            return redirect()->route('datasurat')->with('error', 'Gagal mengupload file surat: ' . $e->getMessage());
        }
    }

    /**
     * Download uploaded surat file
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function downloadUploadedFile($id)
    {
        try {
            $surat = PenerbitanSurat::findOrFail($id);
            
            if (!$surat->file_path || !file_exists(public_path('storage/' . $surat->file_path))) {
                return redirect()->back()->with('error', 'File surat tidak ditemukan');
            }
            
            return response()->download(public_path('storage/' . $surat->file_path));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunduh file: ' . $e->getMessage());
        }
    }
    
    public function datasurat(Request $request)
    {
        // Get search and per_page parameters for main table (draft surat)
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10); // Default 10 items per page
        $sortBy = $request->input('sort_by', 'latest'); // Default to latest
        
        // Get search and per_page parameters for published table (surat diterbitkan)
        $searchPublished = $request->input('search_published', '');
        $perPagePublished = $request->input('per_page_published', 10); // Default 10 items per page
        $sortByPublished = $request->input('sort_by_published', 'latest'); // Default to latest
        
        // Base query with relationships
        $baseQuery = PenerbitanSurat::with(['mahasiswa', 'nonMahasiswa', 'user']);
        
        // Create separate query instances for draft and published surat
        $draftQuery = clone $baseQuery;
        $publishedQuery = clone $baseQuery;
        
        // Filter draft surat (not diterbitkan)
        $draftQuery->where('status_surat', '!=', 'diterbitkan');
        
        // Filter published surat (diterbitkan)
        $publishedQuery->where('status_surat', 'diterbitkan');
        
        // Apply search filter for draft surat if provided
        if ($search) {
            $draftQuery->where(function($q) use ($search) {
                // Search in PenerbitanSurat table
                $q->where('nomor_surat', 'like', '%' . $search . '%')
                ->orWhere('status_penelitian', 'like', '%' . $search . '%')
                ->orWhere('status_surat', 'like', '%' . $search . '%');
                
                // Search in related Mahasiswa
                $q->orWhereHas('mahasiswa', function($mq) use ($search) {
                    $mq->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%')
                    ->orWhere('nama_instansi', 'like', '%' . $search . '%')
                    ->orWhere('judul_penelitian', 'like', '%' . $search . '%');
                });
                
                // Search in related NonMahasiswa
                $q->orWhereHas('nonMahasiswa', function($nmq) use ($search) {
                    $nmq->where('nama_lengkap', 'like', '%' . $search . '%')
                        ->orWhere('no_hp', 'like', '%' . $search . '%')
                        ->orWhere('nama_instansi', 'like', '%' . $search . '%')
                        ->orWhere('judul_penelitian', 'like', '%' . $search . '%');
                });
            });
        }
        
        // Apply search filter for published surat if provided
        if ($searchPublished) {
            $publishedQuery->where(function($q) use ($searchPublished) {
                // Search in PenerbitanSurat table
                $q->where('nomor_surat', 'like', '%' . $searchPublished . '%')
                ->orWhere('status_penelitian', 'like', '%' . $searchPublished . '%');
                
                // Search in related Mahasiswa
                $q->orWhereHas('mahasiswa', function($mq) use ($searchPublished) {
                    $mq->where('nama_lengkap', 'like', '%' . $searchPublished . '%')
                    ->orWhere('no_hp', 'like', '%' . $searchPublished . '%')
                    ->orWhere('nama_instansi', 'like', '%' . $searchPublished . '%')
                    ->orWhere('judul_penelitian', 'like', '%' . $searchPublished . '%');
                });
                
                // Search in related NonMahasiswa
                $q->orWhereHas('nonMahasiswa', function($nmq) use ($searchPublished) {
                    $nmq->where('nama_lengkap', 'like', '%' . $searchPublished . '%')
                        ->orWhere('no_hp', 'like', '%' . $searchPublished . '%')
                        ->orWhere('nama_instansi', 'like', '%' . $searchPublished . '%')
                        ->orWhere('judul_penelitian', 'like', '%' . $searchPublished . '%');
                });
            });
        }

        // Apply sorting for draft table
        if ($sortBy === 'latest') {
            $draftQuery->orderBy('created_at', 'desc');
        } else {
            $draftQuery->orderBy('created_at', 'asc');
        }
        
        // Apply sorting for published table
        if ($sortByPublished === 'latest') {
            $publishedQuery->orderBy('created_at', 'desc');
        } else {
            $publishedQuery->orderBy('created_at', 'asc');
        }
        
        // Get paginated results for both tables
        $penerbitanSurats = $draftQuery->paginate($perPage)->withQueryString();
        $penerbitanSuratsPublished = $publishedQuery->paginate($perPagePublished, ['*'], 'page_published')
                                                ->withQueryString();
        
        // Get notifications for the layout
        $unreadNotifications = $this->getUnreadNotifications();
        $newApplicationNotifications = $this->getNewApplicationNotifications();
        $verificationNotifications = $this->getVerificationNotifications();
        $suratNotifications = $this->getSuratNotifications();
        
        // Return view with data for both tables
        return view('staff.datasurat', compact(
            'penerbitanSurats',
            'penerbitanSuratsPublished',
            'search',
            'perPage',
            'searchPublished',
            'perPagePublished',
            'sortBy',
            'sortByPublished',
            'unreadNotifications',
            'newApplicationNotifications',
            'verificationNotifications',
            'suratNotifications'
        ));
    }

    
    /**
     * Update surat data
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateSurat(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'nomor_surat' => 'required|string',
                'menimbang' => 'nullable|string',
                'tembusan' => 'nullable|string',
                'file_surat' => 'nullable|file|mimes:doc,docx,pdf|max:5120', // Max 5MB
            ], [
                'nomor_surat.required' => 'Nomor surat harus diisi',
                'file_surat.file' => 'Upload harus berupa file',
                'file_surat.mimes' => 'Format file harus doc, docx, atau pdf',
                'file_surat.max' => 'Ukuran file maksimal 5MB',
            ]);

            // Get the surat data
            $surat = PenerbitanSurat::findOrFail($id);
            
            // Update basic data
            $surat->nomor_surat = $request->nomor_surat;
            $surat->menimbang = $request->menimbang;
            $surat->tembusan = $request->tembusan;
            
            // Handle file upload if a new file is provided
            if ($request->hasFile('file_surat')) {
                // Define storage directory
                $directory = 'documents/surat_penelitian';
                
                // Ensure directory exists
                if (!file_exists(public_path('storage/' . $directory))) {
                    mkdir(public_path('storage/' . $directory), 0777, true);
                }
                
                // Delete old file if it exists
                if ($surat->file_path && file_exists(public_path('storage/' . $surat->file_path))) {
                    unlink(public_path('storage/' . $surat->file_path));
                }
                
                // Save the new file
                $file = $request->file('file_surat');
                $fileName = 'surat_penelitian_' . $surat->nomor_surat . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Use move to avoid permission issues
                $file->move(public_path('storage/' . $directory), $fileName);
                $filePath = $directory . '/' . $fileName;
                
                // Update file path in database
                $surat->file_path = $filePath;
                
                // Add status history entry
                if ($surat->mahasiswa_id) {
                    $this->addStatusHistory(
                        'mahasiswa', 
                        $surat->mahasiswa_id, 
                        'surat_diupdate', 
                        'File surat dengan nomor ' . $surat->nomor_surat . ' telah diperbarui'
                    );

                    // Create notification for surat update
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Surat Penelitian Diperbarui';
                    $notifikasi->pesan = 'Data surat penelitian dengan nomor ' . $surat->nomor_surat . ' telah diperbarui';
                    $notifikasi->tipe = 'info';
                    $notifikasi->tipe_peneliti = 'mahasiswa';
                    $notifikasi->mahasiswa_id = $surat->mahasiswa_id;
                    $notifikasi->user_id = auth()->id();
                    $notifikasi->penerbitan_surat_id = $surat->id;
                    $notifikasi->save();
                } else {
                    $this->addStatusHistory(
                        'non_mahasiswa', 
                        $surat->non_mahasiswa_id, 
                        'surat_diupdate', 
                        'File surat dengan nomor ' . $surat->nomor_surat . ' telah diperbarui'
                    );

                    // Create notification for surat update
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Surat Penelitian Diperbarui';
                    $notifikasi->pesan = 'Data surat penelitian dengan nomor ' . $surat->nomor_surat . ' telah diperbarui';
                    $notifikasi->tipe = 'info';
                    $notifikasi->tipe_peneliti = 'non_mahasiswa';
                    $notifikasi->non_mahasiswa_id = $surat->non_mahasiswa_id;
                    $notifikasi->user_id = auth()->id();
                    $notifikasi->penerbitan_surat_id = $surat->id;
                    $notifikasi->save();
                }
            }
            
            // Save changes
            $surat->save();
            
            return redirect()->route('datasurat')->with('success', 'Data surat berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('datasurat')->with('error', 'Gagal memperbarui data surat: ' . $e->getMessage());
        }
    }

    public function updateStatus($id)
    {
        try {
            $penerbitanSurat = PenerbitanSurat::findOrFail($id);
            $oldStatus = $penerbitanSurat->status_surat;
            $penerbitanSurat->status_surat = 'diterbitkan';
            $penerbitanSurat->save();
            
            // Add status history entry
            if ($penerbitanSurat->mahasiswa_id) {
                $this->addStatusHistory(
                    'mahasiswa', 
                    $penerbitanSurat->mahasiswa_id, 
                    'surat_diterbitkan', 
                    'Surat penelitian dengan nomor ' . $penerbitanSurat->nomor_surat . ' telah diterbitkan dan siap untuk diambil'
                );
                
                // Create notification for surat publishing
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Surat Penelitian Diterbitkan';
                $notifikasi->pesan = 'Surat penelitian dengan nomor ' . $penerbitanSurat->nomor_surat . ' telah diterbitkan dan siap untuk diambil';
                $notifikasi->tipe = 'success';
                $notifikasi->tipe_peneliti = 'mahasiswa';
                $notifikasi->mahasiswa_id = $penerbitanSurat->mahasiswa_id;
                $notifikasi->user_id = auth()->id();
                $notifikasi->penerbitan_surat_id = $penerbitanSurat->id;
                $notifikasi->save();
            } else {
                $this->addStatusHistory(
                    'non_mahasiswa', 
                    $penerbitanSurat->non_mahasiswa_id, 
                    'surat_diterbitkan', 
                    'Surat penelitian dengan nomor ' . $penerbitanSurat->nomor_surat . ' telah diterbitkan dan siap untuk diambil'
                );
                
                // Create notification for surat publishing
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Surat Penelitian Diterbitkan';
                $notifikasi->pesan = 'Surat penelitian dengan nomor ' . $penerbitanSurat->nomor_surat . ' telah diterbitkan dan siap untuk diambil';
                $notifikasi->tipe = 'success';
                $notifikasi->tipe_peneliti = 'non_mahasiswa';
                $notifikasi->non_mahasiswa_id = $penerbitanSurat->non_mahasiswa_id;
                $notifikasi->user_id = auth()->id();
                $notifikasi->penerbitan_surat_id = $penerbitanSurat->id;
                $notifikasi->save();
            }
            
            return redirect()->route('datasurat')->with('success', 'Status surat berhasil diubah menjadi diterbitkan');
        } catch (\Exception $e) {
            return redirect()->route('datasurat')->with('error', 'Gagal mengubah status surat: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            
            $penerbitanSurat = PenerbitanSurat::findOrFail($id);
            
            // Delete related status history records first
            if ($penerbitanSurat->mahasiswa_id) {
                StatusHistory::where('tipe_peneliti', 'mahasiswa')
                    ->where('mahasiswa_id', $penerbitanSurat->mahasiswa_id)
                    ->where('status', 'like', 'surat%')
                    ->delete();
            } else if ($penerbitanSurat->non_mahasiswa_id) {
                StatusHistory::where('tipe_peneliti', 'non_mahasiswa')
                    ->where('non_mahasiswa_id', $penerbitanSurat->non_mahasiswa_id)
                    ->where('status', 'like', 'surat%')
                    ->delete();
            }
            
            // Delete generated Word document if it exists
            if ($penerbitanSurat->file_path) {
                $filePath = public_path('storage/' . $penerbitanSurat->file_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            // Also check for any generated documents with pattern matching the nomor_surat
            $documentPattern = public_path('storage/documents/surat_penelitian/surat_penelitian_' . $penerbitanSurat->nomor_surat . '_*.docx');
            $matchingFiles = glob($documentPattern);
            
            foreach ($matchingFiles as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            
            // Now it's safe to delete the penerbitan surat record
            $penerbitanSurat->delete();
            
            // Commit the transaction
            DB::commit();
            
            return redirect()->route('datasurat')->with('success', 'Data surat berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            return redirect()->route('datasurat')->with('error', 'Gagal menghapus data surat: ' . $e->getMessage());
        }
    }

    public function datapengajuanmahasiswa(Request $request)
    {
        // Main table search and pagination params
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10);
        $sortBy = $request->input('sort_by', 'latest'); // Default to latest

        // Rejected table search and pagination params
        $searchRejected = $request->input('search_rejected', '');
        $perPageRejected = $request->input('per_page_rejected', 10);
        $sortByRejected = $request->input('sort_by_rejected', 'latest'); // Default to latest for rejected table

        // Query for non-rejected applications
        $mahasiswasQuery = Mahasiswa::query()->where('status', '!=', 'ditolak');

        if ($search) {
            $mahasiswasQuery->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                ->orWhere('nim', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

         // Apply sorting
        if ($sortBy === 'latest') {
            $mahasiswasQuery->orderBy('created_at', 'desc');
        } else {
            $mahasiswasQuery->orderBy('created_at', 'asc');
        }

        // Get list of mahasiswa IDs that already have associated letters
        $mahasiswaIdsWithLetters = PenerbitanSurat::where('jenis_surat', 'mahasiswa')
            ->whereNotNull('mahasiswa_id')
            ->pluck('mahasiswa_id')
            ->toArray();

        // Get paginated mahasiswa data
        $mahasiswas = $mahasiswasQuery->paginate($perPage);
        
        // Attach has_letter flag to each mahasiswa
        $mahasiswas->getCollection()->transform(function ($mahasiswa) use ($mahasiswaIdsWithLetters) {
            $mahasiswa->has_letter = in_array($mahasiswa->id, $mahasiswaIdsWithLetters);
            return $mahasiswa;
        });
        
        // Query for rejected applications with pagination
        $ditolakMahasiswasQuery = Mahasiswa::with('notifikasis')
                                    ->where('status', 'ditolak');
        
        if ($searchRejected) {
            $ditolakMahasiswasQuery->where(function($q) use ($searchRejected) {
                $q->where('nama_lengkap', 'like', '%' . $searchRejected . '%')
                ->orWhere('nim', 'like', '%' . $searchRejected . '%')
                ->orWhere('email', 'like', '%' . $searchRejected . '%')
                ->orWhere('judul_penelitian', 'like', '%' . $searchRejected . '%');
            });
        }

        // Apply sorting to rejected table using its own parameter
        if ($sortByRejected === 'latest') {
            $ditolakMahasiswasQuery->orderBy('updated_at', 'desc');
        } else {
            $ditolakMahasiswasQuery->orderBy('updated_at', 'asc');
        }
        
        $ditolakMahasiswas = $ditolakMahasiswasQuery->paginate($perPageRejected, ['*'], 'page_rejected');

        // Get notifications for the layout
        $unreadNotifications = $this->getUnreadNotifications();
        $newApplicationNotifications = $this->getNewApplicationNotifications();
        $verificationNotifications = $this->getVerificationNotifications();
        $suratNotifications = $this->getSuratNotifications();
        
        return view('staff.datapengajuanmahasiswa', compact(
            'mahasiswas', 
            'ditolakMahasiswas', 
            'search', 
            'perPage',
            'searchRejected',
            'perPageRejected',
            'sortBy',
            'sortByRejected',
            'unreadNotifications',
            'newApplicationNotifications',
            'verificationNotifications',
            'suratNotifications'
        ));
    }

    public function tolakPengajuan(Request $request, $id)
    {
        try {
            $mahasiswa = Mahasiswa::findOrFail($id);
            $oldStatus = $mahasiswa->status;
            $mahasiswa->status = 'ditolak';
            $mahasiswa->save();
            
            // Create notification for the rejection
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Penelitian Ditolak';
            $notifikasi->pesan = 'Pengajuan penelitian dengan judul "' . $mahasiswa->judul_penelitian . '" telah ditolak.';
            $notifikasi->tipe = 'danger';
            $notifikasi->tipe_peneliti = 'mahasiswa';
            $notifikasi->mahasiswa_id = $mahasiswa->id;
            $notifikasi->user_id = auth()->id();
            $notifikasi->alasan_penolakan = $request->alasan_penolakan ?? 'Tidak memenuhi persyaratan';
            $notifikasi->save();
            
            // Add to status history with additional message about resubmission
            $this->addStatusHistory(
                'mahasiswa', 
                $mahasiswa->id, 
                'ditolak', 
                'Pengajuan ditolak dengan alasan: ' . ($request->alasan_penolakan ?? 'Tidak memenuhi persyaratan') . '. Silahkan perbaiki berkas Anda dan kirimkan kembali dalam waktu maksimal 3 hari setelah pemberitahuan penolakan.'
            );
            
            return redirect()->route('datapengajuanmahasiswa')->with('success', 'Status pengajuan berhasil diubah menjadi Ditolak');
        } catch (\Exception $e) {
            return redirect()->route('datapengajuanmahasiswa')->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }
    
    public function prosesKembali($id)
    {
        try {
            $mahasiswa = Mahasiswa::findOrFail($id);
            $oldStatus = $mahasiswa->status;
            $mahasiswa->status = 'diterima';
            $mahasiswa->save();
            
            // Add to status history
            $this->addStatusHistory(
                'mahasiswa', 
                $mahasiswa->id, 
                'diterima', 
                'Berkas pengajuan telah diterima dan sedang diproses lebih lanjut'
            );

            // Create notification for acceptance
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Penelitian Diterima';
            $notifikasi->pesan = 'Pengajuan penelitian dengan judul "' . $mahasiswa->judul_penelitian . '" telah diterima dan sedang diproses lebih lanjut.';
            $notifikasi->tipe = 'success';
            $notifikasi->tipe_peneliti = 'mahasiswa';
            $notifikasi->mahasiswa_id = $mahasiswa->id;
            $notifikasi->user_id = auth()->id();
            $notifikasi->save();
            
            return redirect()->route('datapengajuanmahasiswa')->with('success', 'Status pengajuan berhasil diubah menjadi Diterima');
        } catch (\Exception $e) {
            return redirect()->route('datapengajuanmahasiswa')->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    public function hapusPengajuan($id)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            
            $mahasiswa = Mahasiswa::findOrFail($id);
            
            // Delete all related records in other tables first
            
            // Delete related status history records
            StatusHistory::where('tipe_peneliti', 'mahasiswa')
                ->where('mahasiswa_id', $id)
                ->delete();
                
            // Delete related notifications
            Notifikasi::where('tipe_peneliti', 'mahasiswa')
                ->where('mahasiswa_id', $id)
                ->delete();
                
            // Delete related penerbitan surat records
            $penerbitanSurat = PenerbitanSurat::where('mahasiswa_id', $id)->first();
            if ($penerbitanSurat) {
                // Delete the generated document if it exists
                if ($penerbitanSurat->file_path) {
                    $filePath = public_path('storage/' . $penerbitanSurat->file_path);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
                
                // Delete the record
                $penerbitanSurat->delete();
            }
            
            // Delete the associated files from storage
            if ($mahasiswa->surat_pengantar_instansi) {
                // Delete from storage/app/public
                Storage::delete('public/' . $mahasiswa->surat_pengantar_instansi);
                // Also delete from public/storage/uploads if it exists
                $uploadPath = public_path('storage/uploads/' . basename($mahasiswa->surat_pengantar_instansi));
                if (file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
            }
            
            if ($mahasiswa->proposal_penelitian) {
                Storage::delete('public/' . $mahasiswa->proposal_penelitian);
                $uploadPath = public_path('storage/uploads/' . basename($mahasiswa->proposal_penelitian));
                if (file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
            }
            
            if ($mahasiswa->ktp) {
                Storage::delete('public/' . $mahasiswa->ktp);
                $uploadPath = public_path('storage/uploads/' . basename($mahasiswa->ktp));
                if (file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
            }
            
            // Now it's safe to delete the mahasiswa record
            $mahasiswa->delete();
            
            // Commit the transaction
            DB::commit();
            
            return redirect()->route('datapengajuanmahasiswa')->with('success', 'Data pengajuan berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            return redirect()->route('datapengajuanmahasiswa')->with('error', 'Gagal menghapus pengajuan: ' . $e->getMessage());
        }
    }
   
    public function datapengajuannonmahasiswa(Request $request)
    {
        // Main table search and pagination params
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10);
        $sortBy = $request->input('sort_by', 'latest'); // Default to latest

        // Rejected table search and pagination params
        $searchRejected = $request->input('search_rejected', '');
        $perPageRejected = $request->input('per_page_rejected', 10);
        $sortByRejected = $request->input('sort_by_rejected', 'latest'); // Add separate sort parameter for rejected table

        // Query for non-rejected applications
        $nonMahasiswasQuery = NonMahasiswa::query()->where('status', '!=', 'ditolak');

        if ($search) {
            $nonMahasiswasQuery->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('nama_instansi', 'like', '%' . $search . '%');
            });
        }

        // Apply sorting for main table
        if ($sortBy === 'latest') {
            $nonMahasiswasQuery->orderBy('created_at', 'desc');
        } else {
            $nonMahasiswasQuery->orderBy('created_at', 'asc');
        }

        // Get list of non_mahasiswa IDs that already have associated letters
        $nonMahasiswaIdsWithLetters = PenerbitanSurat::where('jenis_surat', 'non_mahasiswa')
            ->whereNotNull('non_mahasiswa_id')
            ->pluck('non_mahasiswa_id')
            ->toArray();

        // Get paginated non-mahasiswa data
        $nonMahasiswas = $nonMahasiswasQuery->paginate($perPage);
        
        // Attach has_letter flag to each non-mahasiswa
        $nonMahasiswas->getCollection()->transform(function ($nonMahasiswa) use ($nonMahasiswaIdsWithLetters) {
            $nonMahasiswa->has_letter = in_array($nonMahasiswa->id, $nonMahasiswaIdsWithLetters);
            return $nonMahasiswa;
        });
        
        // Query for rejected applications with pagination
        $ditolakNonMahasiswasQuery = NonMahasiswa::with('notifikasis')
                                        ->where('status', 'ditolak');
        
        if ($searchRejected) {
            $ditolakNonMahasiswasQuery->where(function($q) use ($searchRejected) {
                $q->where('nama_lengkap', 'like', '%' . $searchRejected . '%')
                ->orWhere('email', 'like', '%' . $searchRejected . '%')
                ->orWhere('nama_instansi', 'like', '%' . $searchRejected . '%')
                ->orWhere('judul_penelitian', 'like', '%' . $searchRejected . '%');
            });
        }

        // Apply sorting to rejected table using its own parameter
        if ($sortByRejected === 'latest') {
            $ditolakNonMahasiswasQuery->orderBy('updated_at', 'desc');
        } else {
            $ditolakNonMahasiswasQuery->orderBy('updated_at', 'asc');
        }
        
        $ditolakNonMahasiswas = $ditolakNonMahasiswasQuery->paginate($perPageRejected, ['*'], 'page_rejected');

        // Get notifications for the layout
        $unreadNotifications = $this->getUnreadNotifications();
        $newApplicationNotifications = $this->getNewApplicationNotifications();
        $verificationNotifications = $this->getVerificationNotifications();
        $suratNotifications = $this->getSuratNotifications();
        
        return view('staff.datapengajuannonmahasiswa', compact(
            'nonMahasiswas', 
            'ditolakNonMahasiswas', 
            'search', 
            'perPage',
            'searchRejected',
            'perPageRejected',
            'sortBy',
            'sortByRejected',
            'unreadNotifications',
            'newApplicationNotifications',
            'verificationNotifications',
            'suratNotifications'
        ));
    }

    public function tolakPengajuanNonMahasiswa(Request $request, $id)
    {
        try {
            $nonMahasiswa = NonMahasiswa::findOrFail($id);
            $oldStatus = $nonMahasiswa->status;
            $nonMahasiswa->status = 'ditolak';
            $nonMahasiswa->save();
            
            // Create notification for the rejection
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Penelitian Ditolak';
            $notifikasi->pesan = 'Pengajuan penelitian dengan judul "' . $nonMahasiswa->judul_penelitian . '" telah ditolak.';
            $notifikasi->tipe = 'danger';
            $notifikasi->tipe_peneliti = 'non_mahasiswa';
            $notifikasi->non_mahasiswa_id = $nonMahasiswa->id;
            $notifikasi->user_id = auth()->id();
            $notifikasi->alasan_penolakan = $request->alasan_penolakan ?? 'Tidak memenuhi persyaratan';
            $notifikasi->save();
            
            // Add to status history with additional message about resubmission
            $this->addStatusHistory(
                'non_mahasiswa', 
                $nonMahasiswa->id, 
                'ditolak', 
                'Pengajuan ditolak dengan alasan: ' . ($request->alasan_penolakan ?? 'Tidak memenuhi persyaratan') . '. Silahkan perbaiki berkas Anda dan kirimkan kembali dalam waktu maksimal 3 hari setelah pemberitahuan penolakan.'
            );
            
            return redirect()->route('datapengajuannonmahasiswa')->with('success', 'Status pengajuan berhasil diubah menjadi Ditolak');
        } catch (\Exception $e) {
            return redirect()->route('datapengajuannonmahasiswa')->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    public function prosesKembaliNonMahasiswa($id)
    {
        try {
            $nonMahasiswa = NonMahasiswa::findOrFail($id);
            $oldStatus = $nonMahasiswa->status;
            $nonMahasiswa->status = 'diterima'; // Changed from 'diproses' to 'diterima'
            $nonMahasiswa->save();
            
            // Add to status history
            $this->addStatusHistory(
                'non_mahasiswa', 
                $nonMahasiswa->id, 
                'diterima', 
                'Berkas pengajuan telah diterima dan sedang diproses lebih lanjut'
            );

            // Create notification for acceptance
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Penelitian Diterima';
            $notifikasi->pesan = 'Pengajuan penelitian dengan judul "' . $nonMahasiswa->judul_penelitian . '" telah diterima dan sedang diproses lebih lanjut.';
            $notifikasi->tipe = 'success';
            $notifikasi->tipe_peneliti = 'non_mahasiswa';
            $notifikasi->non_mahasiswa_id = $nonMahasiswa->id;
            $notifikasi->user_id = auth()->id();
            $notifikasi->save();
            
            return redirect()->route('datapengajuannonmahasiswa')->with('success', 'Status pengajuan berhasil diubah menjadi Diterima');
        } catch (\Exception $e) {
            return redirect()->route('datapengajuannonmahasiswa')->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    public function hapusPengajuanNonMahasiswa($id)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            
            $nonMahasiswa = NonMahasiswa::findOrFail($id);
            
            // Delete all related records in other tables first
            
            // Delete related status history records
            StatusHistory::where('tipe_peneliti', 'non_mahasiswa')
                ->where('non_mahasiswa_id', $id)
                ->delete();
                
            // Delete related notifications
            Notifikasi::where('tipe_peneliti', 'non_mahasiswa')
                ->where('non_mahasiswa_id', $id)
                ->delete();
                
            // Delete related penerbitan surat records
            $penerbitanSurat = PenerbitanSurat::where('non_mahasiswa_id', $id)->first();
            if ($penerbitanSurat) {
                // Delete the generated document if it exists
                if ($penerbitanSurat->file_path) {
                    $filePath = public_path('storage/' . $penerbitanSurat->file_path);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
                
                // Delete the record
                $penerbitanSurat->delete();
            }
            
            // Delete the associated files from storage
            if ($nonMahasiswa->surat_pengantar_instansi) {
                Storage::delete('public/' . $nonMahasiswa->surat_pengantar_instansi);
                $uploadPath = public_path('storage/uploads/' . basename($nonMahasiswa->surat_pengantar_instansi));
                if (file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
            }
            
            if ($nonMahasiswa->akta_notaris_lembaga) {
                Storage::delete('public/' . $nonMahasiswa->akta_notaris_lembaga);
                $uploadPath = public_path('storage/uploads/' . basename($nonMahasiswa->akta_notaris_lembaga));
                if (file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
            }
            
            if ($nonMahasiswa->surat_terdaftar_kemenkumham) {
                Storage::delete('public/' . $nonMahasiswa->surat_terdaftar_kemenkumham);
                $uploadPath = public_path('storage/uploads/' . basename($nonMahasiswa->surat_terdaftar_kemenkumham));
                if (file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
            }
            
            if ($nonMahasiswa->ktp) {
                Storage::delete('public/' . $nonMahasiswa->ktp);
                $uploadPath = public_path('storage/uploads/' . basename($nonMahasiswa->ktp));
                if (file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
            }
            
            if ($nonMahasiswa->proposal_penelitian) {
                Storage::delete('public/' . $nonMahasiswa->proposal_penelitian);
                $uploadPath = public_path('storage/uploads/' . basename($nonMahasiswa->proposal_penelitian));
                if (file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
            }
            
            if ($nonMahasiswa->surat_pernyataan) {
                Storage::delete('public/' . $nonMahasiswa->surat_pernyataan);
                $uploadPath = public_path('storage/uploads/' . basename($nonMahasiswa->surat_pernyataan));
                if (file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
            }
            
            // Now it's safe to delete the non-mahasiswa record
            $nonMahasiswa->delete();
            
            // Commit the transaction
            DB::commit();
            
            return redirect()->route('datapengajuannonmahasiswa')->with('success', 'Data pengajuan berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            return redirect()->route('datapengajuannonmahasiswa')->with('error', 'Gagal menghapus pengajuan: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to add a status history entry
     */
    private function addStatusHistory($tipe_peneliti, $peneliti_id, $status, $notes = null)
    {
        try {
            $statusHistory = new StatusHistory();
            $statusHistory->status = $status;
            $statusHistory->notes = $notes;
            $statusHistory->tipe_peneliti = $tipe_peneliti;
            $statusHistory->user_id = auth()->id();
            
            if ($tipe_peneliti === 'mahasiswa') {
                $statusHistory->mahasiswa_id = $peneliti_id;
                $statusHistory->non_mahasiswa_id = null;
            } else {
                $statusHistory->mahasiswa_id = null;
                $statusHistory->non_mahasiswa_id = $peneliti_id;
            }
            
            $statusHistory->save();
            return true;
        } catch (\Exception $e) {
            // Log the error but don't interrupt the main flow
            \Log::error('Failed to add status history: ' . $e->getMessage());
            return false;
        }
    }

    public function markAllNotificationsAsRead()
    {
        try {
            // Update all unread notifications to read
            Notifikasi::where('telah_dibaca', false)->update(['telah_dibaca' => true]);
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}