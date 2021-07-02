<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 広告会社の契約情報を扱うModel
 */
class Contract extends Model
{
    use SoftDeletes;

    protected $dates   = ['started_at', 'ended_at', 'schedule_ended_at', 'approve_at'];
    protected $guarded = [];

    public function priceWithUnit()
    {
        return '¥'.$this->price;
    }

    public function addingCount()
    {
        $count = 0;
        switch($this->period) {
            case '1ヶ月':
                $count = 1;
                break;

            case '3ヶ月':
                $count = 3;
                break;

            case '6ヶ月':
                $count = 6;
                break;

            case '12ヶ月':
                $count = 12;
                break;
        }
        return $count;
    }

    public function startedAt()
    {
        return $this->started_at ? $this->started_at->format('Y-m-d') : '';
    }

    public function endedAt()
    {
        return $this->ended_at ? $this->ended_at->format('Y-m-d') : '';
    }

    public function approveAt()
    {
        return $this->approve_at ? $this->approve_at->format('Y-m-d') : '';
    }

    public function scheduleEndedAt()
    {
        return $this->schedule_ended_at ? $this->schedule_ended_at->format('Y-m-d') : '';
    }

    /**
     * リレーション：広告会社
     *
     * @return void
     */
    public function advertisement()
    {
        return $this->belongsTo('App\Advertisement');
    }

}
