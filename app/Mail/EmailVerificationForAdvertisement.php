<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationForAdvertisement extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;
    protected $advertisement;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $advertisement)
    {
        $this->token         = $token;
        $this->advertisement = $advertisement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【CATTOBI】広告契約についてのご案内')
            ->text('emails.advertisement.verification')
            ->with([
                'token'         => $this->token,
                'advertisement' => $this->advertisement,
            ]);
    }
}
