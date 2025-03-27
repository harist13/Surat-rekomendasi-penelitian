<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\NonMahasiswa;
use App\Models\StatusHistory;
use Illuminate\Support\Facades\Storage;

class FormPengajuanController extends Controller
{
    public function pengajuanmahasiswa()
    {
        return view('pengajuan_mahasiswa');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:mahasiswa',
            'email' => 'required|email|max:255|unique:mahasiswa',
            'no_hp' => 'required|string|max:15',
            'alamat_peneliti' => 'required|string',
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'jurusan' => 'required|string|max:255',
            'judul_penelitian' => 'required|string',
            'lama_penelitian' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi_penelitian' => 'required|string',
            'tujuan_penelitian' => 'required|string',
            'anggota_peneliti' => 'required|string',
            'surat_pengantar_instansi' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'proposal_penelitian' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'ktp' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'status' => 'required|string',
        ]);

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
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'nim' => $validatedData['nim'],
                'email' => $validatedData['email'],
                'no_hp' => $validatedData['no_hp'],
                'alamat_peneliti' => $validatedData['alamat_peneliti'],
                'nama_instansi' => $validatedData['nama_instansi'],
                'alamat_instansi' => $validatedData['alamat_instansi'],
                'jurusan' => $validatedData['jurusan'],
                'judul_penelitian' => $validatedData['judul_penelitian'],
                'lama_penelitian' => $validatedData['lama_penelitian'],
                'tanggal_mulai' => $validatedData['tanggal_mulai'],
                'tanggal_selesai' => $validatedData['tanggal_selesai'],
                'lokasi_penelitian' => $validatedData['lokasi_penelitian'],
                'tujuan_penelitian' => $validatedData['tujuan_penelitian'],
                'anggota_peneliti' => $validatedData['anggota_peneliti'],
                'surat_pengantar_instansi' => $suratPengantarPath,
                'proposal_penelitian' => $proposalPath,
                'ktp' => $ktpPath,
                'status' => $validatedData['status'],
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

    public function storeNonMahasiswa(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:non_mahasiswa',
            'no_hp' => 'required|string|max:15',
            'alamat_peneliti' => 'required|string',
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'bidang' => 'required|string|max:255',
            'judul_penelitian' => 'required|string',
            'lama_penelitian' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi_penelitian' => 'required|string',
            'tujuan_penelitian' => 'required|string',
            'anggota_peneliti' => 'required|string',
            'surat_pengantar_instansi' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'akta_notaris_lembaga' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'surat_terdaftar_kemenkumham' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'ktp' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'proposal_penelitian' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'lampiran_rincian_lokasi' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'status' => 'required|string',
        ]);

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
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'jabatan' => $validatedData['jabatan'],
                'email' => $validatedData['email'],
                'no_hp' => $validatedData['no_hp'],
                'alamat_peneliti' => $validatedData['alamat_peneliti'],
                'nama_instansi' => $validatedData['nama_instansi'],
                'alamat_instansi' => $validatedData['alamat_instansi'],
                'bidang' => $validatedData['bidang'],
                'judul_penelitian' => $validatedData['judul_penelitian'],
                'lama_penelitian' => $validatedData['lama_penelitian'],
                'tanggal_mulai' => $validatedData['tanggal_mulai'],
                'tanggal_selesai' => $validatedData['tanggal_selesai'],
                'lokasi_penelitian' => $validatedData['lokasi_penelitian'],
                'tujuan_penelitian' => $validatedData['tujuan_penelitian'],
                'anggota_peneliti' => $validatedData['anggota_peneliti'],
                'surat_pengantar_instansi' => $suratPengantarPath,
                'akta_notaris_lembaga' => $aktaNotarisPath,
                'surat_terdaftar_kemenkumham' => $suratTerdaftarPath,
                'ktp' => $ktpPath,
                'proposal_penelitian' => $proposalPath,
                'lampiran_rincian_lokasi' => $lampiranPath,
                'status' => $validatedData['status'],
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