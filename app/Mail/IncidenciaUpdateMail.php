<?php

namespace App\Mail;

use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IncidenciaUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @params $incidencia Objeto modelo Incidencia, $user objeto modelo User
     * @return none
     */
    public $incidencia;
    public $user;
    public function __construct(Incidencia $incidencia, User $user)
    {
        $this->incidencia = $incidencia;
        $this->user = $user;
    }

    /**
     * Asunto del correo
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Incidencia Actualizada',
        );
    }

    /**
     * Get the message content definition.
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.correoActualizacion',
            with: ['incidencia' => $this->incidencia, 'usuario' => $this->user],
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
