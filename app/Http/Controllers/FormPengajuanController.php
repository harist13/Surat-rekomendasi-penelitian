<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\NonMahasiswa;
use App\Models\StatusHistory;
use App\Http\Requests\PengajuanMahasiswaRequest;
use App\Http\Requests\PengajuanNonMahasiswaRequest;
use Illuminate\Support\Facades\Storage;

class FormPengajuanController extends Controller
{
    public function pengajuanmahasiswa()
    {
        return view('pengajuan_mahasiswa');
    }

     public function store(PengajuanMahasiswaRequest $request)
    {
        try {
            // Generate unique application number (no_pengajuan)
            $prefix = 'PGN';
            $middle = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $suffix = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            $noPengajuan = "{$prefix}-{$middle}-{$suffix}";

            // Store the files
            $suratPengantarPath = $request->file('surat_pengantar_instansi')->store('uploads', 'public');
            $proposalPath = $request->file('proposal_penelitian')->store('uploads', 'public');
            $ktpPath = $request->file('ktp')->store('uploads', 'public');

            // Store the data in the database
            $mahasiswa = Mahasiswa::create([
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
                'surat_pengantar_instansi' => $suratPengantarPath,
                'proposal_penelitian' => $proposalPath,
                'ktp' => $ktpPath,
                'status' => $request->status,
            ]);
            
            // Add initial status history
            $this->addStatusHistory(
                'mahasiswa', 
                $mahasiswa->id, 
                'pengajuan_diterima', 
                'Pengajuan diterima oleh sistem'
            );

            return redirect()->route('pengajuanmahasiswa')->with('success', "Pengajuan berhasil disimpan dengan nomor pengajuan {$noPengajuan}. Simpan nomor pengajuan dengan baik agar bisa melacak status pengajuan.");
        } catch (\Exception $e) {
            return redirect()->route('pengajuanmahasiswa')->withErrors(['error' => 'Terjadi kesalahan saat menyimpan pengajuan: ' . $e->getMessage()]);
        }
    }

    public function pengajuannonmahasiswa()
    {
        return view('pengajuan_non_mahasiswa');
    }

     public function storeNonMahasiswa(PengajuanNonMahasiswaRequest $request)
    {
        try {
            // Generate unique application number (no_pengajuan)
            $prefix = 'PGN';
            $middle = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $suffix = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            $noPengajuan = "{$prefix}-{$middle}-{$suffix}";

            // Store the files
            $suratPengantarPath = $request->file('surat_pengantar_instansi')->store('uploads', 'public');
            $aktaNotarisPath = $request->file('akta_notaris_lembaga')->store('uploads', 'public');
            $suratTerdaftarPath = $request->file('surat_terdaftar_kemenkumham')->store('uploads', 'public');
            $ktpPath = $request->file('ktp')->store('uploads', 'public');
            $proposalPath = $request->file('proposal_penelitian')->store('uploads', 'public');
            $lampiranPath = $request->file('lampiran_rincian_lokasi')->store('uploads', 'public');

            // Store the data in the database
            $nonMahasiswa = NonMahasiswa::create([
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
                'surat_pengantar_instansi' => $suratPengantarPath,
                'akta_notaris_lembaga' => $aktaNotarisPath,
                'surat_terdaftar_kemenkumham' => $suratTerdaftarPath,
                'ktp' => $ktpPath,
                'proposal_penelitian' => $proposalPath,
                'lampiran_rincian_lokasi' => $lampiranPath,
                'status' => $request->status,
            ]);
            
            // Add initial status history
            $this->addStatusHistory(
                'non_mahasiswa', 
                $nonMahasiswa->id, 
                'pengajuan_diterima', 
                'Pengajuan diterima oleh sistem'
            );

            return redirect()->route('pengajuannonmahasiswa')->with('success', "Pengajuan berhasil disimpan dengan nomor pengajuan {$noPengajuan}. Simpan nomor pengajuan dengan baik agar bisa melacak status pengajuan.");
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
}