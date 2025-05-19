<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\NonMahasiswa;
use App\Models\PenerbitanSurat;
use App\Models\Notifikasi;
use App\Models\StatusHistory;
use App\Models\SurveiKepuasan;
use App\Models\SurveiQuestion;
use App\Models\SurveiResponse;

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

    public function syarat(){
        return view('syarat');
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

        // Cek apakah ini adalah permintaan untuk mengajukan ulang
        if (request()->has('resubmit') && $data->status == 'ditolak') {
            if ($tipe == 'mahasiswa') {
                return redirect()->route('pengajuanmahasiswa', ['no_pengajuan' => $no_pengajuan]);
            } else {
                return redirect()->route('pengajuannonmahasiswa', ['no_pengajuan' => $no_pengajuan]);
            }
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

    public function layanan()
    {
        return view('layanan');
    }

    public function survei()
    {
        // Fetch active survey questions from the database
        $surveiQuestions = SurveiQuestion::all();
        
        return view('survei', compact('surveiQuestions'));
    }

    // Create submission method for the survey
    public function submitSurvei(Request $request)
    {
        // Validate the form input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'no_hp' => 'required|string',
            'usia' => 'required|numeric',
            'jenis_layanan' => 'required|string|in:Mahasiswa,Non-Mahasiswa',
            'kritik_saran' => 'nullable|string',
        ]);

        // Check if we have any survey questions answered
        $hasAnswers = false;
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'question_') === 0) {
                $hasAnswers = true;
                break;
            }
        }

        if (!$hasAnswers) {
            return redirect()->route('survei')->with('error', 'Mohon jawab setidaknya satu pertanyaan survei.');
        }
        
        try {
            // Store user demographics
            $userData = [
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia' => $request->usia,
                'kritik_saran' => $request->kritik_saran,
                'jenis_layanan' => $request->jenis_layanan,
            ];
            
            // Process each question response
            $responsesCount = 0;
            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'question_') === 0) {
                    $questionId = substr($key, 9);
                    
                    // Verify the question exists
                    $question = SurveiQuestion::find($questionId);
                    
                    if ($question) {
                        // Create a survey response
                        SurveiResponse::create([
                            'question_id' => $questionId,
                            'nama' => $userData['nama'],
                            'email' => $userData['email'],
                            'no_hp' => $userData['no_hp'],
                            'jenis_kelamin' => $userData['jenis_kelamin'],
                            'usia' => $userData['usia'],
                            'rating' => $value, // Store the rating (1-5)
                            'kritik_saran' => $userData['kritik_saran'],
                            'jenis_layanan' => $userData['jenis_layanan'],
                        ]);
                        
                        $responsesCount++;
                    }
                }
            }
            
            if ($responsesCount > 0) {
                return redirect()->route('survei')->with('success', 'Terima kasih! Survei Anda telah berhasil dikirim.');
            } else {
                return redirect()->route('survei')->with('error', 'Tidak ada jawaban yang disimpan. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            return redirect()->route('survei')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}