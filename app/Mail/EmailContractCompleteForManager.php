<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailContractCompleteForManager extends Mailable
{
    use Queueable, SerializesModels;

    protected $contract;
    protected $advertisement;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contract, $advertisement)
    {
        $this->contract      = $contract;
        $this->advertisement = $advertisement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【CATTOBI】'.$this->advertisement->company.'様と広告契約を締結しました')
            ->text('emails.manager.contract_notice')
            ->with([
                'contract'      => $this->contract,
                'advertisement' => $this->advertisement,
            ]);
    }
}
