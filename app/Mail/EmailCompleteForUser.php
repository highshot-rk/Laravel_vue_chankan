<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailCompleteForUser extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【CATTOBI】ログインURLのご案内')
            ->text('emails.user.complete')
            ->with([
                'user'     => $this->user,
                'password' => $this->password,
            ]);
    }
}
