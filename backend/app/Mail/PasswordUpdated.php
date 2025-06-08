<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;

    public function __construct(public string $password, string $name)
    {
        $this->name = $name;
    }

    public function build(): static
    {
        return $this
            ->subject('Ваш пароль был обновлён')
            ->view('emails.password_updated');
    }
}
