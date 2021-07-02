<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailCompleteForCharge extends Mailable
{
    use Queueable, SerializesModels;

    protected $charge;
    protected $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($charge, $password)
    {
        $this->charge = $charge;
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
            ->text('emails.charge.complete')
            ->with([
                'charge'   => $this->charge,
                'password' => $this->password,
            ]);
    }
}
