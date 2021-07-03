<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class SurveyImage extends Model
{
    protected $appends = ['survey_image_url'];
    use SoftDeletes;
    

    /**
     * リレーション：画像URL
     *
     * @return void
     */

    public function getSurveyImageUrlAttribute()
    {
        if (empty($this->img))
            return '/assets/img/icon_batu_white.png';

        return Storage::disk('public')->url(str_replace('public/', '', $this->img));
    }
}
