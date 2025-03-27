<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\NonMahasiswa;
use App\Models\PenerbitanSurat;
use App\Models\Notifikasi;
use App\Models\StatusHistory;

class HomeController extends Controller
{
    public function index(){
        return view('home');
    }
    
    public function tentang(){
        return view('tentang');
    }
    
    public function kontak(){
        return view('kontak');
    }
    
    public function pantau(){
        return view('pantau');
    }

    public function cekStatus(Request $request)
    {
        $request->validate(['no_pengajuan' => 'required|string']);
        return redirect()->route('pantau.show', $request->no_pengajuan);
    }

    public function showStatus($no_pengajuan)
    {
        // Cari di kedua tabel
        $mahasiswa = Mahasiswa::where('no_pengajuan', $no_pengajuan)->first();
        $nonMahasiswa = NonMahasiswa::where('no_pengajuan', $no_pengajuan)->first();
        
        $data = $mahasiswa ?? $nonMahasiswa;
        $tipe = $mahasiswa ? 'mahasiswa' : 'non_mahasiswa';

        if (!$data) {
            return redirect()->route('pantau')->with('error', 'Nomor pengajuan tidak ditemukan');
        }

        // Get related data
        $penerbitan = PenerbitanSurat::where($tipe.'_id', $data->id)->first();
        $notifikasis = Notifikasi::where($tipe.'_id', $data->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        // Get status history
        $statusHistories = StatusHistory::where($tipe.'_id', $data->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('pantau', compact('data', 'tipe', 'penerbitan', 'notifikasis', 'statusHistories'));
    }
}