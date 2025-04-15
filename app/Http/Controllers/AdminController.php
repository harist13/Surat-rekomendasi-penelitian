<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\NonMahasiswa;
use App\Models\PenerbitanSurat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Storage;
use PDF;

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
        
        return view('admin.index', compact('totalUsers', 'totalPending', 'approvedDocuments', 'monthlyStats'));
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
        return view('admin.akun', compact('users', 'roles', 'search', 'perPage'));
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
    return view('admin.datasurat', compact('penerbitanSurats', 'search', 'perPage', 'statusFilter'));
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
        
        // Process anggota peneliti
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
        
        // Prepare data for the view
        $data = [
            'surat' => $surat,
            'peneliti' => $peneliti,
            'kategori' => $kategori,
            'jabatan' => $jabatan,
            'nim' => $nim,
            'bidang' => $bidang,
            'tanggalSurat' => $tanggalSurat,
            'waktuPenelitian' => $waktuPenelitian,
            'anggotaText' => $anggotaText
        ];
        
        // Generate PDF using DomPDF
        $pdf = PDF::loadView('staff.surat.surat_penelitian', $data);
        
        // Set PDF options
        $pdf->setPaper('a4');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'Times New Roman'
        ]);
        
        // Create directory if it doesn't exist
        $directory = storage_path('app/public/documents/surat_penelitian');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        
        // Save PDF to file
        $fileName = 'surat_penelitian_' . $surat->nomor_surat . '_' . time() . '.pdf';
        $filePath = 'documents/surat_penelitian/' . $fileName;
        $pdf->save(storage_path('app/public/' . $filePath));
        
        return $filePath;
    }
}