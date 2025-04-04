<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\RejectionNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalNotification;

class NotificationController extends Controller
{
    public function sendWhatsAppNotification(Request $request)
    {
        $pesan = $request->pesan;
        $nomor = $request->nomor;
        $token = 'cqCVAsH6VpH9rnPL16W1';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('target' => $nomor ,'message' => $pesan),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim');
    }

     public function sendEmailNotification(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'nullable|exists:mahasiswa,id',
            'non_mahasiswa_id' => 'nullable|exists:non_mahasiswa,id',
            'email' => 'required|email',
            'nama' => 'required|string',
            'no_pengajuan' => 'required|string',
            'judul_penelitian' => 'required|string',
            'alasan_penolakan' => 'required|string',
            'pesan_email' => 'required|string',
        ]);

        try {
            Mail::to($request->email)->send(new RejectionNotification(
                $request->nama,
                $request->no_pengajuan,
                $request->judul_penelitian,
                $request->alasan_penolakan,
                $request->pesan_email
            ));

            return redirect()->back()->with('success', 'Email notifikasi berhasil dikirim');
        } catch (\Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }


     public function sendApprovalEmailNotification(Request $request)
    {
        $validated = $request->validate([
            'surat_id' => 'required|exists:penerbitan_surat,id',
            'email' => 'required|email',
            'nama' => 'required|string',
            'judul_penelitian' => 'required|string',
            'nomor_surat' => 'required|string',
            'pesan_email' => 'required|string',
        ]);

        try {
            Mail::to($request->email)->send(new ApprovalNotification(
                $request->nama,
                $request->judul_penelitian,
                $request->nomor_surat,
                $request->pesan_email
            ));

            return redirect()->back()->with('success', 'Email notifikasi penerbitan surat berhasil dikirim');
        } catch (\Exception $e) {
            Log::error('Error sending approval email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }
}