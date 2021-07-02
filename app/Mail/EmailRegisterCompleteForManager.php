<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailRegisterCompleteForManager extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('CATTOBIサービスのログイン情報')
            ->text('emails.manager.register_notice')
            ->with([
                'email' => $this->email,
            ]);
    }
}
