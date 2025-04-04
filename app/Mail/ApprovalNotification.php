<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApprovalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $judul_penelitian;
    public $nomor_surat;
    public $pesan_email;

    /**
     * Create a new message instance.
     */
    public function __construct($nama, $judul_penelitian, $nomor_surat, $pesan_email)
    {
        $this->nama = $nama;
        $this->judul_penelitian = $judul_penelitian;
        $this->nomor_surat = $nomor_surat;
        $this->pesan_email = $pesan_email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Penerbitan Surat Izin Penelitian',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.approval-notification',
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