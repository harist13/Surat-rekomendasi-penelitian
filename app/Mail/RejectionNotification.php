<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RejectionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $no_pengajuan;
    public $judul_penelitian;
    public $alasan_penolakan;
    public $pesan_email;

    /**
     * Create a new message instance.
     */
    public function __construct($nama, $no_pengajuan, $judul_penelitian, $alasan_penolakan, $pesan_email)
    {
        $this->nama = $nama;
        $this->no_pengajuan = $no_pengajuan;
        $this->judul_penelitian = $judul_penelitian;
        $this->alasan_penolakan = $alasan_penolakan;
        $this->pesan_email = $pesan_email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Penolakan Pengajuan Penelitian',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.rejection-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}