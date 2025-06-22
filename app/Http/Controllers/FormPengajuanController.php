<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\NonMahasiswa;
use App\Models\StatusHistory;
use App\Models\Notifikasi; // Tambahkan import untuk model Notifikasi
use App\Http\Requests\PengajuanMahasiswaRequest;
use App\Http\Requests\PengajuanNonMahasiswaRequest;
use Illuminate\Support\Facades\Storage;

class FormPengajuanController extends Controller
{
    public function pengajuanmahasiswa(Request $request)
    {
        $mahasiswa = null;
        $rejectionReason = null;
        
        // Jika ada parameter no_pengajuan, ambil data pengajuan sebelumnya
        if ($request->has('no_pengajuan')) {
            $mahasiswa = Mahasiswa::where('no_pengajuan', $request->no_pengajuan)->first();
            
            // Jika pengajuan ditemukan dan berstatus ditolak, ambil alasan penolakan
            if ($mahasiswa && $mahasiswa->status == 'ditolak') {
                $notification = Notifikasi::where('mahasiswa_id', $mahasiswa->id)
                    ->where('alasan_penolakan', '!=', null)
                    ->latest()
                    ->first();
                    
                if ($notification) {
                    $rejectionReason = $notification->alasan_penolakan;
                }
            }
        }
        
        return view('pengajuan_mahasiswa', compact('mahasiswa', 'rejectionReason'));
    }

     public function store(PengajuanMahasiswaRequest $request)
    {
        try {
            // Cek apakah ini pengajuan ulang
            $isResubmission = false;
            $existingMahasiswa = null;
            
            if ($request->filled('existing_id')) {
                $existingMahasiswa = Mahasiswa::find($request->existing_id);
                $isResubmission = true;
            } else if ($request->filled('no_pengajuan')) {
                $existingMahasiswa = Mahasiswa::where('no_pengajuan', $request->no_pengajuan)->first();
                $isResubmission = ($existingMahasiswa !== null);
            }
            
            // Generate unique application number (no_pengajuan) jika bukan pengajuan ulang
            if (!$isResubmission) {
                $prefix = 'PGN';
                $middle = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
                $suffix = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                $noPengajuan = "{$prefix}-{$middle}-{$suffix}";
            } else {
                // Gunakan nomor pengajuan yang sama untuk pengajuan ulang
                $noPengajuan = $existingMahasiswa->no_pengajuan;
            }

            // Store the files
            $suratPengantarPath = $request->hasFile('surat_pengantar_instansi') ? 
                $request->file('surat_pengantar_instansi')->store('uploads', 'public') :
                ($existingMahasiswa ? $existingMahasiswa->surat_pengantar_instansi : null);
            
            $proposalPath = $request->hasFile('proposal_penelitian') ? 
                $request->file('proposal_penelitian')->store('uploads', 'public') :
                ($existingMahasiswa ? $existingMahasiswa->proposal_penelitian : null);
            
            $ktpPath = $request->hasFile('ktp') ? 
                $request->file('ktp')->store('uploads', 'public') :
                ($existingMahasiswa ? $existingMahasiswa->ktp : null);

            // Create new or update existing data
            $mahasiswaData = [
                'no_pengajuan' => $noPengajuan,
                'nama_lengkap' => $request->nama_lengkap,
                'nim' => $request->nim,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat_peneliti' => $request->alamat_peneliti,
                'nama_instansi' => $request->nama_instansi,
                'alamat_instansi' => $request->alamat_instansi,
                'jurusan' => $request->jurusan,
                'judul_penelitian' => $request->judul_penelitian,
                'lama_penelitian' => $request->lama_penelitian,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'lokasi_penelitian' => $request->lokasi_penelitian,
                'tujuan_penelitian' => $request->tujuan_penelitian,
                'anggota_peneliti' => $request->anggota_peneliti,
                'status' => 'diproses',  // Selalu reset status menjadi "diproses"
            ];
            
            if ($suratPengantarPath) $mahasiswaData['surat_pengantar_instansi'] = $suratPengantarPath;
            if ($proposalPath) $mahasiswaData['proposal_penelitian'] = $proposalPath;
            if ($ktpPath) $mahasiswaData['ktp'] = $ktpPath;

            if ($isResubmission) {
                // Update data yang sudah ada
                $mahasiswa = $existingMahasiswa;
                $mahasiswa->update($mahasiswaData);
                
                $this->addStatusHistory(
                    'mahasiswa', 
                    $mahasiswa->id, 
                    'pengajuan_ulang', 
                    'Pengajuan ulang setelah ditolak'
                );
                
                // Buat notifikasi untuk pengajuan ulang
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Pengajuan Ulang';
                $notifikasi->pesan = 'Pengajuan mahasiswa ulang dari ' . $request->nama_lengkap . ' dengan NIM ' . $request->nim . ' judul penelitian: ' . $request->judul_penelitian;
                $notifikasi->tipe = 'warning';
                $notifikasi->tipe_peneliti = 'mahasiswa';
                $notifikasi->mahasiswa_id = $mahasiswa->id;
                $notifikasi->telah_dibaca = false;
                $notifikasi->save();
            } else {
                // Buat data baru
                $mahasiswa = Mahasiswa::create($mahasiswaData);
                
                // Add initial status history
                $this->addStatusHistory(
                    'mahasiswa', 
                    $mahasiswa->id, 
                    'pengajuan_diterima', 
                    'Pengajuan diterima oleh sistem'
                );
                
                // Buat notifikasi untuk pengajuan baru
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Pengajuan Baru';
                $notifikasi->pesan = 'Pengajuan mahasiswa baru dari ' . $request->nama_lengkap . ' dengan NIM ' . $request->nim . ' judul penelitian: ' . $request->judul_penelitian;
                $notifikasi->tipe = 'info';
                $notifikasi->tipe_peneliti = 'mahasiswa';
                $notifikasi->mahasiswa_id = $mahasiswa->id;
                $notifikasi->telah_dibaca = false;
                $notifikasi->save();
            }

            $successMessage = $isResubmission 
                ? "Pengajuan ulang berhasil dikirim dengan nomor pengajuan {$noPengajuan} Status pengajuan telah diubah kembali menjadi 'Diproses'." 
                : "Pengajuan berhasil disimpan dengan nomor pengajuan {$noPengajuan} Simpan nomor pengajuan dengan baik agar bisa melacak status pengajuan. Staff akan melakukan verifikasi dokumen dalam 1-2 hari jam kerja setelah pengajuan masuk ke sistem.";

            return redirect()->route('pengajuanmahasiswa')->with('success', $successMessage);
        } catch (\Exception $e) {
            return redirect()->route('pengajuanmahasiswa')->withErrors(['error' => 'Terjadi kesalahan saat menyimpan pengajuan: ' . $e->getMessage()]);
        }
    }

    public function pengajuannonmahasiswa(Request $request)
    {
        $nonMahasiswa = null;
        $rejectionReason = null;
        
        // Jika ada parameter no_pengajuan, ambil data pengajuan sebelumnya
        if ($request->has('no_pengajuan')) {
            $nonMahasiswa = NonMahasiswa::where('no_pengajuan', $request->no_pengajuan)->first();
            
            // Jika pengajuan ditemukan dan berstatus ditolak, ambil alasan penolakan
            if ($nonMahasiswa && $nonMahasiswa->status == 'ditolak') {
                $notification = Notifikasi::where('non_mahasiswa_id', $nonMahasiswa->id)
                    ->where('alasan_penolakan', '!=', null)
                    ->latest()
                    ->first();
                    
                if ($notification) {
                    $rejectionReason = $notification->alasan_penolakan;
                }
            }
        }
        
        return view('pengajuan_non_mahasiswa', compact('nonMahasiswa', 'rejectionReason'));
    }

     public function storeNonMahasiswa(PengajuanNonMahasiswaRequest $request)
    {
        try {
            // Cek apakah ini pengajuan ulang
            $isResubmission = false;
            $existingNonMahasiswa = null;
            
            if ($request->filled('existing_id')) {
                $existingNonMahasiswa = NonMahasiswa::find($request->existing_id);
                $isResubmission = true;
            } else if ($request->filled('no_pengajuan')) {
                $existingNonMahasiswa = NonMahasiswa::where('no_pengajuan', $request->no_pengajuan)->first();
                $isResubmission = ($existingNonMahasiswa !== null);
            }
            
            // Generate unique application number (no_pengajuan) jika bukan pengajuan ulang
            if (!$isResubmission) {
                $prefix = 'PGN';
                $middle = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
                $suffix = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                $noPengajuan = "{$prefix}-{$middle}-{$suffix}";
            } else {
                // Gunakan nomor pengajuan yang sama untuk pengajuan ulang
                $noPengajuan = $existingNonMahasiswa->no_pengajuan;
            }

            // Store the files
            $suratPengantarPath = $request->hasFile('surat_pengantar_instansi') ? 
                $request->file('surat_pengantar_instansi')->store('uploads', 'public') : 
                ($existingNonMahasiswa ? $existingNonMahasiswa->surat_pengantar_instansi : null);
            
            $aktaNotarisPath = $request->hasFile('akta_notaris_lembaga') ? 
                $request->file('akta_notaris_lembaga')->store('uploads', 'public') : 
                ($existingNonMahasiswa ? $existingNonMahasiswa->akta_notaris_lembaga : null);
            
            $suratTerdaftarPath = $request->hasFile('surat_terdaftar_kemenkumham') ? 
                $request->file('surat_terdaftar_kemenkumham')->store('uploads', 'public') : 
                ($existingNonMahasiswa ? $existingNonMahasiswa->surat_terdaftar_kemenkumham : null);
            
            $ktpPath = $request->hasFile('ktp') ? 
                $request->file('ktp')->store('uploads', 'public') : 
                ($existingNonMahasiswa ? $existingNonMahasiswa->ktp : null);
            
            $proposalPath = $request->hasFile('proposal_penelitian') ? 
                $request->file('proposal_penelitian')->store('uploads', 'public') : 
                ($existingNonMahasiswa ? $existingNonMahasiswa->proposal_penelitian : null);
            
            $pernyataanPath = $request->hasFile('surat_pernyataan') ? 
                $request->file('surat_pernyataan')->store('uploads', 'public') : 
                ($existingNonMahasiswa ? $existingNonMahasiswa->surat_pernyataan : null);

            // Data to save
            $nonMahasiswaData = [
                'no_pengajuan' => $noPengajuan,
                'nama_lengkap' => $request->nama_lengkap,
                'jabatan' => $request->jabatan,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat_peneliti' => $request->alamat_peneliti,
                'nama_instansi' => $request->nama_instansi,
                'alamat_instansi' => $request->alamat_instansi,
                'bidang' => $request->bidang,
                'judul_penelitian' => $request->judul_penelitian,
                'lama_penelitian' => $request->lama_penelitian,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'lokasi_penelitian' => $request->lokasi_penelitian,
                'tujuan_penelitian' => $request->tujuan_penelitian,
                'anggota_peneliti' => $request->anggota_peneliti,
                'status' => 'diproses', // Selalu reset status menjadi "diproses"
            ];
            
            if ($suratPengantarPath) $nonMahasiswaData['surat_pengantar_instansi'] = $suratPengantarPath;
            if ($aktaNotarisPath) $nonMahasiswaData['akta_notaris_lembaga'] = $aktaNotarisPath;
            if ($suratTerdaftarPath) $nonMahasiswaData['surat_terdaftar_kemenkumham'] = $suratTerdaftarPath;
            if ($ktpPath) $nonMahasiswaData['ktp'] = $ktpPath;
            if ($proposalPath) $nonMahasiswaData['proposal_penelitian'] = $proposalPath;
            if ($pernyataanPath) $nonMahasiswaData['surat_pernyataan'] = $pernyataanPath;

            if ($isResubmission) {
                // Update data yang sudah ada
                $nonMahasiswa = $existingNonMahasiswa;
                $nonMahasiswa->update($nonMahasiswaData);
                
                $this->addStatusHistory(
                    'non_mahasiswa', 
                    $nonMahasiswa->id, 
                    'pengajuan_ulang', 
                    'Pengajuan ulang setelah ditolak'
                );
                
                // Buat notifikasi untuk pengajuan ulang
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Pengajuan Ulang';
                $notifikasi->pesan = 'Pengajuan non-mahasiswa ulang dari ' . $request->nama_lengkap . ' (' . $request->nama_instansi . ') judul penelitian: ' . $request->judul_penelitian;
                $notifikasi->tipe = 'warning';
                $notifikasi->tipe_peneliti = 'non_mahasiswa';
                $notifikasi->non_mahasiswa_id = $nonMahasiswa->id;
                $notifikasi->telah_dibaca = false;
                $notifikasi->save();
            } else {
                // Buat data baru
                $nonMahasiswa = NonMahasiswa::create($nonMahasiswaData);
                
                // Add initial status history
                $this->addStatusHistory(
                    'non_mahasiswa', 
                    $nonMahasiswa->id, 
                    'pengajuan_diterima', 
                    'Pengajuan diterima oleh sistem'
                );
                
                // Buat notifikasi untuk pengajuan baru
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Pengajuan Baru';
                $notifikasi->pesan = 'Pengajuan non-mahasiswa baru dari ' . $request->nama_lengkap . ' (' . $request->nama_instansi . ') judul penelitian: ' . $request->judul_penelitian;
                $notifikasi->tipe = 'info';
                $notifikasi->tipe_peneliti = 'non_mahasiswa';
                $notifikasi->non_mahasiswa_id = $nonMahasiswa->id;
                $notifikasi->telah_dibaca = false;
                $notifikasi->save();
            }

            $successMessage = $isResubmission 
                ? "Pengajuan ulang berhasil dikirim dengan nomor pengajuan {$noPengajuan} Status pengajuan telah diubah kembali menjadi 'Diproses'." 
                : "Pengajuan berhasil disimpan dengan nomor pengajuan {$noPengajuan} Simpan nomor pengajuan dengan baik agar bisa melacak status pengajuan. Staff akan melakukan verifikasi dokumen dalam 1-2 hari jam kerja setelah pengajuan masuk ke sistem.";

            return redirect()->route('pengajuannonmahasiswa')->with('success', $successMessage);
        } catch (\Exception $e) {
            return redirect()->route('pengajuannonmahasiswa')->withErrors(['error' => 'Terjadi kesalahan saat menyimpan pengajuan: ' . $e->getMessage()]);
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

    /**
     * Show form for resubmitting mahasiswa application
     */
    public function resubmitMahasiswa($no_pengajuan)
    {
        $mahasiswa = Mahasiswa::where('no_pengajuan', $no_pengajuan)
                    ->where('status', 'ditolak')
                    ->first();
                    
        if (!$mahasiswa) {
            return redirect()->route('pengajuanmahasiswa')
                    ->with('error', 'Pengajuan tidak ditemukan atau tidak berstatus ditolak');
        }
        
        // Get rejection reason if available
        $notification = Notifikasi::where('mahasiswa_id', $mahasiswa->id)
                ->where('alasan_penolakan', '!=', null)
                ->latest()
                ->first();
                
        $rejectionReason = $notification ? $notification->alasan_penolakan : null;
        
        return view('pengajuan_mahasiswa', compact('mahasiswa', 'rejectionReason'));
    }

    /**
     * Show form for resubmitting non-mahasiswa application
     */
    public function resubmitNonMahasiswa($no_pengajuan)
    {
        $nonMahasiswa = NonMahasiswa::where('no_pengajuan', $no_pengajuan)
                    ->where('status', 'ditolak')
                    ->first();
                    
        if (!$nonMahasiswa) {
            return redirect()->route('pengajuannonmahasiswa')
                    ->with('error', 'Pengajuan tidak ditemukan atau tidak berstatus ditolak');
        }
        
        // Get rejection reason if available
        $notification = Notifikasi::where('non_mahasiswa_id', $nonMahasiswa->id)
                ->where('alasan_penolakan', '!=', null)
                ->latest()
                ->first();
                
        $rejectionReason = $notification ? $notification->alasan_penolakan : null;
        
        return view('pengajuan_non_mahasiswa', compact('nonMahasiswa', 'rejectionReason'));
    }
}