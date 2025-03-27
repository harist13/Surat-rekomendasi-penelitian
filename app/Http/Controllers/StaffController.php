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
            $penerbitanSurat->status_penelitian = $validatedData['status_penelitian'];
            $penerbitanSurat->status_surat = $validatedData['status_surat'];
            $penerbitanSurat->posisi_surat = 'aktif';
            $penerbitanSurat->user_id = auth()->id();
            // Remove the line that tries to save no_pengajuan

            // Associate with either mahasiswa or non_mahasiswa based on jenis
            if ($validatedData['jenis_surat'] === 'mahasiswa') {
                $penerbitanSurat->mahasiswa_id = $validatedData['pemohon_id'];
                $penerbitanSurat->non_mahasiswa_id = null;
                
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
                
                // Add status history entry
                $this->addStatusHistory(
                    'non_mahasiswa', 
                    $validatedData['pemohon_id'], 
                    'surat_dibuat', 
                    'Surat penelitian telah dibuat dengan nomor ' . $validatedData['nomor_surat']
                );
            }

            $penerbitanSurat->save();

            return redirect()->route('datasurat')->with('success', 'Data surat berhasil diterbitkan');
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