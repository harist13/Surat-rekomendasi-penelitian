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
        // Get search and per_page parameters
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10); // Default 10 items per page
        
        // Base query with relationships, only get published letters
        $query = PenerbitanSurat::with(['mahasiswa', 'nonMahasiswa', 'user'])
                    ->where('status_surat', 'diterbitkan');
        
        // Apply search filter if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                // Search in PenerbitanSurat table
                $q->where('nomor_surat', 'like', '%' . $search . '%')
                ->orWhere('status_penelitian', 'like', '%' . $search . '%');
                
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
        return view('admin.datasurat', compact('penerbitanSurats', 'search', 'perPage'));
    }
}