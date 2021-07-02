<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 現地調査情報のModel
 */
class Survey extends Model
{
    use SoftDeletes;

    /**
     * リレーション：案件
     *
     * @return void
     */
    public function projectLabel()
    {
        return $this->belongsTo('App\ProjectLabel', 'project_label');
    }

    /**
     * リレーション：現地調査画像
     *
     * @return void
     */
    public function surveyImages()
    {
        return $this->hasMany('App\SurveyImage');
    }
}
