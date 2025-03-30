<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\NonMahasiswa;
use App\Models\PenerbitanSurat;
use App\Models\Notifikasi;
use App\Models\StatusHistory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use Carbon\Carbon;

class StaffController extends Controller
{ 
    public function index()
    {
        return view('staff.index');
    }

    public function penerbitan()
    {
        $approvedMahasiswa = Mahasiswa::where('status', 'diterima')->get();
        $approvedNonMahasiswa = NonMahasiswa::where('status', 'diterima')->get();
        
        return view('staff.penerbitan', compact('approvedMahasiswa', 'approvedNonMahasiswa'));
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
        try {
            // Validate the form input
            $validatedData = $request->validate([
                'jenis_surat' => 'required|in:mahasiswa,non_mahasiswa',
                'pemohon_id' => 'required',
                'nomor_surat' => 'required|string',
                'menimbang' => 'nullable|string',
                'status_penelitian' => 'required|in:baru,lanjutan,perpanjangan',
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

            // Create new PenerbitanSurat record
            $penerbitanSurat = new PenerbitanSurat();
            $penerbitanSurat->jenis_surat = $validatedData['jenis_surat'];
            $penerbitanSurat->nomor_surat = $validatedData['nomor_surat'];
            $penerbitanSurat->menimbang = $validatedData['menimbang'] ?? null;
            $penerbitanSurat->status_penelitian = $validatedData['status_penelitian'];
            $penerbitanSurat->status_surat = $validatedData['status_surat'];
            $penerbitanSurat->posisi_surat = 'aktif';
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
                    'Surat penelitian telah dibuat dengan nomor ' . $validatedData['nomor_surat']
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
                    'Surat penelitian telah dibuat dengan nomor ' . $validatedData['nomor_surat']
                );
            }

            $penerbitanSurat->save();
            
            // Generate Word document
            $documentPath = $this->generateSuratPenelitian($penerbitanSurat->id);
            
            // Store the document path in the session
            session(['generated_document' => $documentPath]);

            return redirect()->route('datasurat')->with([
                'success' => 'Data surat berhasil diterbitkan',
                'document_path' => $documentPath
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database errors
            $errorCode = $e->errorInfo[1] ?? '';
            
            if ($errorCode == 1062) {
                // Duplicate entry
                return redirect()->back()->with('error', 'Nomor surat sudah digunakan. Silahkan gunakan nomor surat yang lain.')->withInput();
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan database: ' . $e->getMessage())->withInput();
        } catch (\Exception $e) {
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
        // Get the PenerbitanSurat data with relations
        $surat = PenerbitanSurat::with(['mahasiswa', 'nonMahasiswa', 'user'])->findOrFail($suratId);
        
        // Determine if it's mahasiswa or non-mahasiswa
        if ($surat->jenis_surat === 'mahasiswa') {
            $peneliti = $surat->mahasiswa;
            $kategori = 'Mahasiswa';
            $jabatan = 'Mahasiswa';
            $nim = $peneliti->nim;
            $bidang = $peneliti->jurusan;
        } else {
            $peneliti = $surat->nonMahasiswa;
            $kategori = 'Non-Mahasiswa';
            $jabatan = $peneliti->jabatan;
            $nim = '-';
            $bidang = $peneliti->bidang;
        }
        
        // Format dates
        $tanggalSurat = Carbon::now()->locale('id')->isoFormat('D MMMM Y');
        $waktuPenelitian = $peneliti->tanggal_mulai . ' s.d ' . $peneliti->tanggal_selesai;
        
        // Create a new PHPWord instance
        $phpWord = new PhpWord();
        
        // Set default font
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(12);
        
        // Add a section
        $section = $phpWord->addSection();
        
        // Header with logo and institution name
        $header = $section->addHeader();
        $table = $header->addTable();
        $table->addRow();
        
        $cell1 = $table->addCell(2000);
        $cell1->addImage(public_path('assets/images/logo.png'), ['width' => 80, 'height' => 80, 'alignment' => 'center']);
        
        $cell2 = $table->addCell(9000);
        $cell2->addText("PEMERINTAH PROVINSI KALIMANTAN TIMUR", ['bold' => true, 'size' => 14, 'alignment' => 'center']);
        $cell2->addText("BADAN KESATUAN BANGSA DAN POLITIK", ['bold' => true, 'size' => 14, 'alignment' => 'center']);
        $cell2->addText("Jalan Jenderal Sudirman Nomor 1, Samarinda, Kalimantan Timur 75121", ['size' => 11, 'alignment' => 'center']);
        $cell2->addText("Telepon (0541) 733333; Faksimile (0541) 733453", ['size' => 11, 'alignment' => 'center']);
        $cell2->addText("Pos-el kesbangpol.kaltim@gmail.com; Laman http://kesbangpol.kaltimprov.go.id", ['size' => 11, 'alignment' => 'center']);
        
        // Add horizontal line
        $section->addText('', [], ['borderBottomSize' => 3, 'borderBottomColor' => '000000']);
        
        // Title
        $section->addText('SURAT KETERANGAN PENELITIAN', ['bold' => true, 'alignment' => 'center'], ['alignment' => 'center', 'spaceAfter' => 0]);
        $section->addText('Nomor: ' . $surat->nomor_surat, ['alignment' => 'center'], ['alignment' => 'center', 'spaceAfter' => 200]);
        
        // Dasar
        $section->addText('a. Dasar', ['bold' => true]);
        $section->addText('    1. Peraturan Menteri Dalam Negeri Nomor 3 Tahun 2018 tentang Penerbitan Surat Keterangan Penelitian (Berita Negara Republik Indonesia Tahun 2018 Nomor 122);');
        $section->addText('    2. Peraturan Gubernur Kalimantan Timur Nomor 43 Tahun 2023 tentang Kedudukan, Susunan Organisasi, Tugas, Fungsi, dan Tata Kerja Perangkat Daerah (Berita Daerah Provinsi Kalimantan Timur Tahun 2023 Nomor 46);');
        
        // Menimbang
        if ($surat->menimbang) {
            $section->addText('b. Menimbang', ['bold' => true]);
            $section->addText('    ' . $surat->menimbang);
        } else {
            $section->addText('b. Menimbang', ['bold' => true]);
            $section->addText('    1. Surat a.n Dekan, Wakil Dekan Bidang Akademik, Kemahasiswaan dan Alumni, ' . $peneliti->nama_instansi . ' tentang Surat Pengantar Penelitian.');
        }
        
        // Rekomendasi
        $section->addText('Kepala Badan Kesbang dan Politik Prov. Kaltim, memberikan rekomendasi kepada :', ['bold' => true, 'spaceAfter' => 200]);
        
        // Informasi peneliti dalam format tabel
        $infoTable = $section->addTable(['borderSize' => 0, 'cellMargin' => 80]);
        
        // Nama
        $infoTable->addRow();
        $infoTable->addCell(3000)->addText('Nama');
        $infoTable->addCell(500)->addText(':');
        $infoTable->addCell(6000)->addText($peneliti->nama_lengkap);
        
        // Jabatan
        $infoTable->addRow();
        $infoTable->addCell(3000)->addText('Jabatan');
        $infoTable->addCell(500)->addText(':');
        $infoTable->addCell(6000)->addText($jabatan);
        
        // NIM/ID jika mahasiswa
        if ($surat->jenis_surat === 'mahasiswa') {
            $infoTable->addRow();
            $infoTable->addCell(3000)->addText('NIM');
            $infoTable->addCell(500)->addText(':');
            $infoTable->addCell(6000)->addText($peneliti->nim);
        }
        
        // Tempat Tinggal
        $infoTable->addRow();
        $infoTable->addCell(3000)->addText('Tempat Tinggal');
        $infoTable->addCell(500)->addText(':');
        $infoTable->addCell(6000)->addText($peneliti->alamat_peneliti);
        
        // Nama Lembaga dan Alamat
        $infoTable->addRow();
        $infoTable->addCell(3000)->addText('Nama Lembaga / Alamat');
        $infoTable->addCell(500)->addText(':');
        $infoTable->addCell(6000)->addText($peneliti->nama_instansi . '/' . $peneliti->alamat_instansi);
        
        // Judul Proposal
        $infoTable->addRow();
        $infoTable->addCell(3000)->addText('Judul Proposal');
        $infoTable->addCell(500)->addText(':');
        $infoTable->addCell(6000)->addText($peneliti->judul_penelitian);
        
        // Bidang Penelitian
        $infoTable->addRow();
        $infoTable->addCell(3000)->addText('Bidang Penelitian');
        $infoTable->addCell(500)->addText(':');
        $infoTable->addCell(6000)->addText($bidang);
        
        // Status Penelitian
        $infoTable->addRow();
        $infoTable->addCell(3000)->addText('Status Penelitian');
        $infoTable->addCell(500)->addText(':');
        $infoTable->addCell(6000)->addText(ucfirst($surat->status_penelitian));
        
        // Anggota peneliti
        if (!empty($peneliti->anggota_peneliti)) {
            $anggotaText = '';
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
            
            if (!empty($anggotaText)) {
                $infoTable->addRow();
                $infoTable->addCell(3000)->addText('Anggota');
                $infoTable->addCell(500)->addText(':');
                $infoTable->addCell(6000)->addText($anggotaText);
            }
        }
        
        // Lokasi Penelitian
        $infoTable->addRow();
        $infoTable->addCell(3000)->addText('Lokasi Penelitian');
        $infoTable->addCell(500)->addText(':');
        $infoTable->addCell(6000)->addText($peneliti->lokasi_penelitian);
        
        // Waktu/Lama Penelitian
        $infoTable->addRow();
        $infoTable->addCell(3000)->addText('Waktu/Lama Penelitian');
        $infoTable->addCell(500)->addText(':');
        $infoTable->addCell(6000)->addText($waktuPenelitian);
        
        // Tujuan Peneliti
        $infoTable->addRow();
        $infoTable->addCell(3000)->addText('Tujuan Peneliti');
        $infoTable->addCell(500)->addText(':');
        $infoTable->addCell(6000)->addText($peneliti->tujuan_penelitian);
        
        $section->addText('');
        
        // Ketentuan
        $section->addText('Dengan Ketentuan', ['bold' => true]);
        $section->addText('1. Yang bersangkutan berkewajiban menghormati dan mentaati peraturan dan tata tertib yang berlaku diwilayah kegiatan;');
        $section->addText('2. Tidak dibenarkan melakukan penelitian yang tidak sesuai/tidak ada kaitannya dengan judul penelitian dimaksud;');
        $section->addText('3. Setelah selesai penelitian agar menyampaikan 1 (satu) Eksemplar laporan kepada Gubernur Kalimantan Timur Cq. Kepala Badan Kesatuan Bangsa dan Politik Provinsi Kalimantan Timur.');
        
        $section->addText('Demikian rekomendasi ini dibuat untuk dipergunakan seperlunya.');
        
        $section->addText('');
        $section->addText('');
        
        // Signature and footer
        $dateTable = $section->addTable(['borderSize' => 0]);
        $dateTable->addRow();
        $dateTable->addCell(6000);
        $dateCell = $dateTable->addCell(4000);
        $dateCell->addText('Samarinda, ' . $tanggalSurat);
        
        $signTable = $section->addTable(['borderSize' => 0]);
        $signTable->addRow();
        $signTable->addCell(6000);
        $sigCell = $signTable->addCell(4000);
        $sigCell->addText('a.n. Kepala');
        $sigCell->addText('Badan Kewaspadaan Nasional');
        $sigCell->addText('dan Penanganan Konflik');
        $sigCell->addText('');
        $sigCell->addText('');
        $sigCell->addText('');
        $sigCell->addText('');
        $sigCell->addText('Wildan Taufik, S.Pd, M.Si');
        $sigCell->addText('Pembina IV/b');
        $sigCell->addText('NIP. 19750412200212 1 005');
        
        // Tembusan
        $section->addText('');
        $section->addText('Tembusan Yth:', ['bold' => true]);
        $section->addText('1. Gubernur Kalimantan Timur (sebagai laporan)');
        $section->addText('2. Kepala Balitbangda Prov. Kaltim');
        $section->addText('3. Kepala Badan Kesbangpol. Kota Samarinda');
        $section->addText('4. Yang Bersangkutan');
        
        // Save the document
        $fileName = 'surat_penelitian_' . $surat->nomor_surat . '_' . time() . '.docx';
        $filePath = 'documents/surat_penelitian/' . $fileName;
        
        // Pastikan direktori ada dengan izin penuh
        $directory = storage_path('app/public/documents/surat_penelitian');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        
        // Save the document
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/' . $filePath));
        
        return $filePath;
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
                } else {
                    $this->addStatusHistory(
                        'non_mahasiswa', 
                        $surat->non_mahasiswa_id, 
                        'surat_diupdate', 
                        'File surat dengan nomor ' . $surat->nomor_surat . ' telah diperbarui'
                    );
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
        // Get search and per_page parameters
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10); // Default 10 items per page
        
        // Base query with relationships
        $query = PenerbitanSurat::with(['mahasiswa', 'nonMahasiswa', 'user']);
        
        // Apply search filter if provided
        if ($search) {
            $query->where(function($q) use ($search) {
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
        
        // Order by created date, descending
        $query->orderBy('created_at', 'desc');
        
        // Get paginated results
        $penerbitanSurats = $query->paginate($perPage);
        
        // Return view with data
        return view('staff.datasurat', compact('penerbitanSurats', 'search', 'perPage'));
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
                    'Surat penelitian dengan nomor ' . $penerbitanSurat->nomor_surat . ' telah diterbitkan'
                );
            } else {
                $this->addStatusHistory(
                    'non_mahasiswa', 
                    $penerbitanSurat->non_mahasiswa_id, 
                    'surat_diterbitkan', 
                    'Surat penelitian dengan nomor ' . $penerbitanSurat->nomor_surat . ' telah diterbitkan'
                );
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
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10); // Default 10 items per page

        // Query for non-rejected applications
        $mahasiswasQuery = Mahasiswa::query()->where('status', '!=', 'ditolak');

        if ($search) {
            $mahasiswasQuery->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                ->orWhere('nim', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $mahasiswas = $mahasiswasQuery->paginate($perPage);
        
        // Query for rejected applications
        $ditolakMahasiswasQuery = Mahasiswa::with('notifikasis')
                                    ->where('status', 'ditolak');
        
        if ($search) {
            $ditolakMahasiswasQuery->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                ->orWhere('nim', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        $ditolakMahasiswas = $ditolakMahasiswasQuery->get();

        return view('staff.datapengajuanmahasiswa', compact('mahasiswas', 'ditolakMahasiswas', 'search', 'perPage'));
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
            
            // Add to status history
            $this->addStatusHistory(
                'mahasiswa', 
                $mahasiswa->id, 
                'ditolak', 
                'Pengajuan ditolak dengan alasan: ' . ($request->alasan_penolakan ?? 'Tidak memenuhi persyaratan')
            );
            
            return redirect()->route('datapengajuanmahasiswa')->with('success', 'Status pengajuan berhasil diubah menjadi Ditolak dan notifikasi telah dikirim');
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
                'Pengajuan diterima kembali untuk diproses'
            );
            
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
            PenerbitanSurat::where('mahasiswa_id', $id)->delete();
            
            // Delete the associated files from storage
            if ($mahasiswa->surat_pengantar_instansi) {
                Storage::delete($mahasiswa->surat_pengantar_instansi);
            }
            
            if ($mahasiswa->proposal_penelitian) {
                Storage::delete($mahasiswa->proposal_penelitian);
            }
            
            if ($mahasiswa->ktp) {
                Storage::delete($mahasiswa->ktp);
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
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10); // Default 10 items per page

        // Query for non-rejected applications
        $nonMahasiswasQuery = NonMahasiswa::query()->where('status', '!=', 'ditolak');

        if ($search) {
            $nonMahasiswasQuery->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('nama_instansi', 'like', '%' . $search . '%');
            });
        }

        $nonMahasiswas = $nonMahasiswasQuery->paginate($perPage);
        
        // Query for rejected applications
        $ditolakNonMahasiswasQuery = NonMahasiswa::with('notifikasis')
                                        ->where('status', 'ditolak');
        
        if ($search) {
            $ditolakNonMahasiswasQuery->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('nama_instansi', 'like', '%' . $search . '%');
            });
        }
        
        $ditolakNonMahasiswas = $ditolakNonMahasiswasQuery->get();

        return view('staff.datapengajuannonmahasiswa', compact('nonMahasiswas', 'ditolakNonMahasiswas', 'search', 'perPage'));
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
            
            // Add to status history
            $this->addStatusHistory(
                'non_mahasiswa', 
                $nonMahasiswa->id, 
                'ditolak', 
                'Pengajuan ditolak dengan alasan: ' . ($request->alasan_penolakan ?? 'Tidak memenuhi persyaratan')
            );
            
            return redirect()->route('datapengajuannonmahasiswa')->with('success', 'Status pengajuan berhasil diubah menjadi Ditolak dan notifikasi telah dikirim');
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
                'Pengajuan diterima kembali untuk diproses'
            );
            
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
            PenerbitanSurat::where('non_mahasiswa_id', $id)->delete();
            
            // Delete the associated files from storage
            if ($nonMahasiswa->surat_pengantar_instansi) {
                Storage::delete($nonMahasiswa->surat_pengantar_instansi);
            }
            
            if ($nonMahasiswa->akta_notaris_lembaga) {
                Storage::delete($nonMahasiswa->akta_notaris_lembaga);
            }
            
            if ($nonMahasiswa->surat_terdaftar_kemenkumham) {
                Storage::delete($nonMahasiswa->surat_terdaftar_kemenkumham);
            }
            
            if ($nonMahasiswa->ktp) {
                Storage::delete($nonMahasiswa->ktp);
            }
            
            if ($nonMahasiswa->proposal_penelitian) {
                Storage::delete($nonMahasiswa->proposal_penelitian);
            }
            
            if ($nonMahasiswa->lampiran_rincian_lokasi) {
                Storage::delete($nonMahasiswa->lampiran_rincian_lokasi);
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
}