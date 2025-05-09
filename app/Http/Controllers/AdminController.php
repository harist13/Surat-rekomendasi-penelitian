<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\NonMahasiswa;
use App\Models\PenerbitanSurat;
use App\Models\SurveiKepuasan;
use App\Models\SurveiQuestion;
use App\Models\SurveiResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Storage;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;

class AdminController extends Controller
{
     public function index()
    {
        // Count total users
        $totalUsers = User::count();
        
        // Count pending requests (both mahasiswa and non-mahasiswa)
        $pendingMahasiswa = Mahasiswa::whereNotIn('status', ['diterima', 'ditolak'])->count();
        $pendingNonMahasiswa = NonMahasiswa::whereNotIn('status', ['diterima', 'ditolak'])->count();
        $totalPending = $pendingMahasiswa + $pendingNonMahasiswa;
        
        // Count approved documents
        $approvedDocuments = PenerbitanSurat::where('status_surat', 'diterbitkan')->count();
        
        // Get monthly statistics for chart
        $monthlyStats = $this->getMonthlyStatistics();
        
        return view('Admin.index', compact('totalUsers', 'totalPending', 'approvedDocuments', 'monthlyStats'));
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
        }
        
        return [
            'months' => $months,
            'userStats' => $userStats,
            'requestStats' => $requestStats,
            'documentStats' => $documentStats
        ];
    }

   public function akun(Request $request)
    {
        $search = $request->input('search', ''); // Ambil kata kunci pencarian dari request
        $perPage = $request->input('per_page', 10); // Ambil jumlah item per halaman dari request, default 10

        $usersQuery = User::query();

        if ($search) {
            $usersQuery->where('nip', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('no_telp', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
        }

        $users = $usersQuery->paginate($perPage); // Gunakan per_page untuk paginasi
        $roles = Role::all();
        return view('Admin.akun', compact('users', 'roles', 'search', 'perPage'));
    }


     public function storeUser(StoreUserRequest $request)
    {
        // Validasi sudah dilakukan oleh StoreUserRequest
        $validated = $request->validated();

        $user = User::create([
            'nip' => $validated['nip'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'no_telp' => $validated['no_telp'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        // Assign role to user using Spatie
        $user->assignRole($validated['role']);

        return redirect()->route('akun')->with('success', 'User berhasil ditambahkan');
    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        // Validasi sudah dilakukan oleh UpdateUserRequest
        $validated = $request->validated();
        $user = User::findOrFail($id);

        // Remove role from the data being passed to update()
        $userUpdateData = [
            'nip' => $validated['nip'],
            'username' => $validated['username'],
            'no_telp' => $validated['no_telp'],
            'email' => $validated['email'],
        ];

        // Only update password if a new one is provided
        if ($request->filled('password')) {
            $userUpdateData['password'] = Hash::make($request->password);
        }

        $user->update($userUpdateData);

        // Sync roles using Spatie
        $user->syncRoles([$validated['role']]);

        return redirect()->route('akun')->with('success', 'User berhasil diupdate');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('akun')->with('success', 'User berhasil dihapus');
    }

    public function getUsersData()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getUserById($id)
    {
        $user = User::findOrFail($id);
        // Add the user's role to the response data
        $userData = $user->toArray();
        $userData['role'] = $user->getRoleNames()->first();
        return response()->json($userData);
    }

    public function datasurats(Request $request)
{
    // Get filter parameters
    $search = $request->input('search', '');
    $perPage = $request->input('per_page', 10);
    $statusFilter = $request->input('status', 'all'); // Default to 'all'
    
    // Base query with relationships
    $query = PenerbitanSurat::with(['mahasiswa', 'nonMahasiswa', 'user']);
    
    // Apply status filter if provided and not 'all'
    if ($statusFilter !== 'all') {
        $query->where('status_surat', $statusFilter);
    }
    
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
    $penerbitanSurats = $query->paginate($perPage)->withQueryString();
    
    // Return view with data
    return view('Admin.datasurat', compact('penerbitanSurats', 'search', 'perPage', 'statusFilter'));
}

    /**
     * Download document for admin
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function downloadDocument($id)
    {
        try {
            $surat = PenerbitanSurat::findOrFail($id);
            
            // Generate a new document
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
     * Download uploaded file for admin
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

    /**
     * Generate a PDF document for Surat Keterangan Penelitian
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
        $waktuPenelitian = $peneliti->tanggal_mulai . ' s.d ' . $peneliti->tanggal_selesai;

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

        // Simpan file Word
        $fileName = 'surat_penelitian_' . $surat->nomor_surat . '_' . time() . '.docx';
        $filePath = $directory . '/' . $fileName;
        $templateProcessor->saveAs($filePath);

        // Return path relatif untuk disimpan di DB atau digunakan di frontend
        return 'documents/surat_penelitian/' . $fileName;
    }

    // Add this method to AdminController.php

    /**
     * Update the authenticated user's profile
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        // Validate the request data
        $rules = [
            'nip' => 'required|string|max:50',
            'username' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ];
        
        // Only validate password if it was provided
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }
        
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            // Get the authenticated user
            $user = auth()->user();
            
            // Update user data
            $user->nip = $request->nip;
            $user->username = $request->username;
            $user->no_telp = $request->no_telp;
            $user->email = $request->email;
            
            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            // Save changes
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Profile berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function datasurvei(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10);
        
        $query = SurveiQuestion::query();
        
        if ($search) {
            $query->where('pertanyaan', 'like', '%' . $search . '%');
        }
        
        $surveiQuestions = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
        
        return view('Admin.datasurvei', compact('surveiQuestions', 'search', 'perPage'));
    }

    // Update storeSurvei method to create questions
    public function storeSurvei(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
        ]);
        
        SurveiQuestion::create([
            'pertanyaan' => $validated['pertanyaan'],
            'kepuasan_pelayanan' => '1 2 3 4 5', // Set default value
        ]);
        
        return redirect()->route('admin.datasurvei')->with('success', 'Pertanyaan survei berhasil ditambahkan');
    }

    // Update getSurveiById method to get question
    public function getSurveiById($id)
    {
        $survei = SurveiQuestion::findOrFail($id);
        return response()->json($survei);
    }

    // Update updateSurvei method to update question
    public function updateSurvei(Request $request, $id)
    {
        $survei = SurveiQuestion::findOrFail($id);
        
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
        ]);
        
        $survei->pertanyaan = $validated['pertanyaan'];
        $survei->save();
        
        return redirect()->route('admin.datasurvei')->with('success', 'Pertanyaan survei berhasil diperbarui');
    }

    // Update deleteSurvei method to delete question
    public function deleteSurvei($id)
    {
        $survei = SurveiQuestion::findOrFail($id);
        $survei->delete();
        
        return redirect()->route('admin.datasurvei')->with('success', 'Pertanyaan survei berhasil dihapus');
    }

    // Add method to view responses
    /**
     * Display survey responses grouped by user
     */
    /**
     * Display survey responses grouped by user
     */
    /**
     * Display survey responses grouped by user
     */
    public function dataresponden(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10);
        
        // Get responses with their questions
        $query = SurveiResponse::with('question');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('no_hp', 'like', '%' . $search . '%')
                ->orWhereHas('question', function($qn) use ($search) {
                    $qn->where('pertanyaan', 'like', '%' . $search . '%');
                });
            });
        }
        
        // Apply jenis_layanan filter if provided
        if ($request->has('jenis_layanan') && $request->jenis_layanan) {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }
        
        // Get the responses
        $responses = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
        
        // Count unique respondents by email
        $uniqueEmails = SurveiResponse::distinct('email')->count('email');
        
        // Get rating statistics for chart
        $ratingStats = [
            1 => SurveiResponse::where('rating', 1)->count(),
            2 => SurveiResponse::where('rating', 2)->count(),
            3 => SurveiResponse::where('rating', 3)->count(),
            4 => SurveiResponse::where('rating', 4)->count(),
            5 => SurveiResponse::where('rating', 5)->count()
        ];
        
        // Calculate highest and lowest ratings that have at least one response
        $highestRating = 0;
        $lowestRating = 6; // Start higher than any possible rating
        
        foreach ($ratingStats as $rating => $count) {
            if ($count > 0) {
                if ($rating > $highestRating) {
                    $highestRating = $rating;
                }
                if ($rating < $lowestRating) {
                    $lowestRating = $rating;
                }
            }
        }
        
        // If no responses, reset lowestRating
        if (array_sum($ratingStats) === 0) {
            $lowestRating = 0;
        }
        
        // Calculate average rating
        $totalRatings = array_sum($ratingStats);
        $weightedSum = 0;
        foreach ($ratingStats as $rating => $count) {
            $weightedSum += $rating * $count;
        }
        $averageRating = $totalRatings > 0 ? round($weightedSum / $totalRatings, 1) : 0;
        
        return view('Admin.dataresponden', compact(
            'responses', 
            'search', 
            'perPage', 
            'uniqueEmails', 
            'ratingStats', 
            'averageRating', 
            'highestRating',
            'lowestRating',
            'totalRatings'
        ));
    }

    /**
     * Delete all responses from a specific email
     */
    public function deleteRespondenData($email)
    {
        try {
            // Delete all responses with the given email
            $count = SurveiResponse::where('email', $email)->delete();
            
            if ($count > 0) {
                return redirect()->route('admin.dataresponden')
                    ->with('success', "Berhasil menghapus {$count} data responden dengan email {$email}");
            } else {
                return redirect()->route('admin.dataresponden')
                    ->with('error', "Tidak ditemukan data responden dengan email {$email}");
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.dataresponden')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Export survey responses to Excel
     */
    public function exportResponden()
    {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set document properties
        $spreadsheet->getProperties()
                    ->setCreator('Kesbangpol Kaltim')
                    ->setLastModifiedBy('Kesbangpol Kaltim')
                    ->setTitle('Data Responden Survei')
                    ->setSubject('Data Responden Survei')
                    ->setDescription('Data Responden Survei Kepuasan Pengguna');
        
        // Add title (header) row
        $sheet->mergeCells('A1:K1');
        $sheet->setCellValue('A1', 'DATA RESPONDEN SURVEI KEPUASAN PELAYANAN');
        
        // Style the title
        $titleStyle = [
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E0E0E0'],
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        
        $sheet->getStyle('A1:K1')->applyFromArray($titleStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);
        
        // Set column headers (now in row 3 due to title)
        $columns = [
            'A' => 'No',
            'B' => 'Nama',
            'C' => 'Email',
            'D' => 'No HP',
            'E' => 'Jenis Kelamin',
            'F' => 'Usia',
            'G' => 'Jenis Layanan',
            'H' => 'Pertanyaan',
            'I' => 'Rating',
            'J' => 'Kritik & Saran',
            'K' => 'Tanggal'
        ];
        
        // Add header row (now in row 3)
        foreach ($columns as $column => $heading) {
            $sheet->setCellValue($column . '3', $heading);
        }
        
        // Style the header row
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '004AAD'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        
        $sheet->getStyle('A3:K3')->applyFromArray($headerStyle);
        
        // Set row height for header
        $sheet->getRowDimension(3)->setRowHeight(20);
        
        // Add empty row after title for spacing
        $sheet->getRowDimension(2)->setRowHeight(10);
        
        // Get all responses with questions
        $responses = SurveiResponse::with('question')->get();
        
        // Group responses by email
        $groupedResponses = $responses->groupBy('email');
        
        // Add data rows (now starting from row 4)
        $row = 4;
        $respondentNumber = 1;
        
        foreach ($groupedResponses as $email => $userResponses) {
            // Get the first response to get user info
            $firstResponse = $userResponses->first();
            
            // Loop through all responses for this user
            foreach ($userResponses as $index => $response) {
                // Only show respondent number, name, email, etc. on the first question row
                if ($index === 0) {
                    $sheet->setCellValue('A' . $row, $respondentNumber);
                    $sheet->setCellValue('B' . $row, $response->nama);
                    $sheet->setCellValue('C' . $row, $response->email);
                    $sheet->setCellValue('D' . $row, $response->no_hp);
                    $sheet->setCellValue('E' . $row, $response->jenis_kelamin);
                    $sheet->setCellValue('F' . $row, $response->usia);
                    $sheet->setCellValue('G' . $row, $response->jenis_layanan);
                } else {
                    // For subsequent questions, we leave the cells A-G empty
                    $sheet->setCellValue('A' . $row, '');
                    $sheet->setCellValue('B' . $row, '');
                    $sheet->setCellValue('C' . $row, '');
                    $sheet->setCellValue('D' . $row, '');
                    $sheet->setCellValue('E' . $row, '');
                    $sheet->setCellValue('F' . $row, '');
                    $sheet->setCellValue('G' . $row, '');
                }
                
                // Always show the question, rating, and other response-specific data
                $sheet->setCellValue('H' . $row, $response->question ? $response->question->pertanyaan : '-');
                $sheet->setCellValue('I' . $row, $response->rating);
                
                // Show kritik_saran only on the first row for this user
                if ($index === 0) {
                    $sheet->setCellValue('J' . $row, $response->kritik_saran);
                    $sheet->setCellValue('K' . $row, $response->created_at->format('d/m/Y H:i:s'));
                } else {
                    $sheet->setCellValue('J' . $row, '');
                    $sheet->setCellValue('K' . $row, '');
                }
                
                $row++;
            }
            
            // Increment respondent number after processing all responses for a user
            $respondentNumber++;
        }
        
        // Remember the last data row
        $lastDataRow = $row - 1;
        
        // Style the data
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ];
        
        if ($lastDataRow >= 4) { // If there's at least one data row
            $sheet->getStyle('A4:K' . $lastDataRow)->applyFromArray($dataStyle);
        }
        
        // Apply vertical merge for grouped cells
        $startRow = 4;
        foreach ($groupedResponses as $email => $userResponses) {
            $questionCount = count($userResponses);
            
            if ($questionCount > 1) {
                // Merge cells for user info (columns A-G, J-K)
                $sheet->mergeCells('A' . $startRow . ':A' . ($startRow + $questionCount - 1));
                $sheet->mergeCells('B' . $startRow . ':B' . ($startRow + $questionCount - 1));
                $sheet->mergeCells('C' . $startRow . ':C' . ($startRow + $questionCount - 1));
                $sheet->mergeCells('D' . $startRow . ':D' . ($startRow + $questionCount - 1));
                $sheet->mergeCells('E' . $startRow . ':E' . ($startRow + $questionCount - 1));
                $sheet->mergeCells('F' . $startRow . ':F' . ($startRow + $questionCount - 1));
                $sheet->mergeCells('G' . $startRow . ':G' . ($startRow + $questionCount - 1));
                $sheet->mergeCells('J' . $startRow . ':J' . ($startRow + $questionCount - 1));
                $sheet->mergeCells('K' . $startRow . ':K' . ($startRow + $questionCount - 1));
                
                // Center align merged cells
                $sheet->getStyle('A' . $startRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('B' . $startRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('C' . $startRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('D' . $startRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('E' . $startRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('F' . $startRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('G' . $startRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('J' . $startRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('K' . $startRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }
            
            $startRow += $questionCount;
        }
        
        // Add empty row after data
        $row++;
        
        // Add Rating Scale Legend
        $legendStartRow = $row;
        $sheet->mergeCells('A' . $row . ':K' . $row);
        $sheet->setCellValue('A' . $row, 'KETERANGAN SKALA PENILAIAN:');
        $row++;
        
        // Add legend items
        $legendItems = [
            '1 = Sangat Tidak Setuju',
            '2 = Tidak Setuju',
            '3 = Kurang Setuju',
            '4 = Setuju',
            '5 = Sangat Setuju'
        ];
        
        foreach ($legendItems as $item) {
            $sheet->mergeCells('A' . $row . ':K' . $row);
            $sheet->setCellValue('A' . $row, $item);
            $row++;
        }
        
        // Style the legend
        $legendStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
        ];
        
        $sheet->getStyle('A' . $legendStartRow)->applyFromArray($legendStyle);
        
        // Auto size columns
        foreach (array_keys($columns) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Set active sheet index to the first sheet
        $spreadsheet->setActiveSheetIndex(0);
        
        // Create temporary file
        $fileName = 'data-responden-survei-' . date('Y-m-d') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');
        
        // Save file to disk
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);
        
        // Return the file as download
        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
    

    /**
     * Export survey responses to PDF
     */
    public function exportRespondenPdf()
    {
        // Get responses with their questions
        $responses = SurveiResponse::with('question')->get();
        
        // Count unique respondents by email
        $uniqueEmails = SurveiResponse::distinct('email')->count('email');
        
        // Group responses by email
        $groupedResponses = $responses->groupBy('email');
        
        // Get rating statistics for chart
        $ratingStats = [
            1 => SurveiResponse::where('rating', 1)->count(),
            2 => SurveiResponse::where('rating', 2)->count(),
            3 => SurveiResponse::where('rating', 3)->count(),
            4 => SurveiResponse::where('rating', 4)->count(),
            5 => SurveiResponse::where('rating', 5)->count()
        ];
        
        // Calculate highest and lowest ratings that have at least one response
        $highestRating = 0;
        $lowestRating = 6; // Start higher than any possible rating
        
        foreach ($ratingStats as $rating => $count) {
            if ($count > 0) {
                if ($rating > $highestRating) {
                    $highestRating = $rating;
                }
                if ($rating < $lowestRating) {
                    $lowestRating = $rating;
                }
            }
        }
        
        // If no responses, reset lowestRating
        if (array_sum($ratingStats) === 0) {
            $lowestRating = 0;
        }
        
        // Calculate average rating
        $totalRatings = array_sum($ratingStats);
        $weightedSum = 0;
        foreach ($ratingStats as $rating => $count) {
            $weightedSum += $rating * $count;
        }
        $averageRating = $totalRatings > 0 ? round($weightedSum / $totalRatings, 1) : 0;
        
        // Create chart image
        $chartUrl = $this->generateChartImageUrl($ratingStats);
        
        // Pass data to view for PDF rendering
        $data = [
            'responses' => $responses,
            'groupedResponses' => $groupedResponses,
            'uniqueEmails' => $uniqueEmails,
            'ratingStats' => $ratingStats,
            'highestRating' => $highestRating,
            'lowestRating' => $lowestRating,
            'averageRating' => $averageRating,
            'chartUrl' => $chartUrl,
            'totalRatings' => $totalRatings
        ];
        
        // Generate PDF using DomPDF
        $pdf = PDF::loadview('Admin.pdf.dataresponden', $data);
        
        // Set PDF options
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif'
        ]);
        
        // Return the file as download
        return $pdf->download('data-responden-survei-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Generate chart image URL using QuickChart.io
     */
    /**
     * Generate chart image URL using QuickChart.io
     */
    private function generateChartImageUrl($ratingStats)
    {
        // Calculate total responses for percentage calculation
        $totalResponses = array_sum($ratingStats);
        
        // Calculate percentages for each rating
        $percentages = [];
        foreach ($ratingStats as $rating => $count) {
            $percentages[$rating] = $totalResponses > 0 ? round(($count / $totalResponses) * 100, 1) : 0;
        }
        
        // Create labels with percentages
        
        
        // Prepare chart data
        $chartData = [
            'type' => 'pie',
            'data' => [
                        'labels' => [
                        "1 - Sangat Tidak Setuju", 
                        "2 - Tidak Setuju", 
                        "3 - Kurang Setuju", 
                        "4 - Setuju", 
                        "5 - Sangat Setuju"
                    ],
                'datasets' => [
                    [
                        'data' => [
                            $ratingStats[1],
                            $ratingStats[2],
                            $ratingStats[3],
                            $ratingStats[4],
                            $ratingStats[5]
                        ],
                        'backgroundColor' => [
                            '#FF6384', // Red
                            '#FFCE56', // Yellow
                            '#36A2EB', // Blue
                            '#4BC0C0', // Teal
                            '#9966FF'  // Purple
                        ]
                    ]
                ]
            ],
            'options' => [
                'plugins' => [
                    'legend' => [
                        'position' => 'right'
                    ],
                    'tooltip' => [
                        'callbacks' => [
                            'label' => "function(context) { return context.label; }"
                        ]
                    ],
                    'datalabels' => [
                        'display' => false // Hide the data values on the chart
                    ]
                ]
            ]
        ];
        
        // Convert chart configuration to JSON and encode for URL
        $chartConfig = urlencode(json_encode($chartData));
        
        // Generate URL for QuickChart.io
        return "https://quickchart.io/chart?c={$chartConfig}&w=500&h=300";
    }

}