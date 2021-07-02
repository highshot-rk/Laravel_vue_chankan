<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 案件ラベルのModel
 */
class ProjectLabel extends Model
{
    use SoftDeletes;

    /**
     * リレーション：案件
     *
     * @return void
     */
    public function projects()
    {
        return $this->hasMany('App\Project', 'label');
    }

    /**
     * リレーション：案件(1つのみ)
     *
     * @return void
     */
    public function project()
    {
        return $this->hasOne('App\Project', 'label')->orderBy('work_on', 'desc');
    }

    /**
     * リレーション：現地調査
     *
     * @return void
     */
    public function survey()
    {
        return $this->hasOne('App\Survey', 'project_label');
    }

    /**
     * 未解体案件を取得
     *
     * @return void
     */
    public function undisassembledProjects()
    {
        return $this->hasMany('App\Project')->where('project_type', config('const.project.type.undisassembled'));
    }

    /**
     * 解体案件を取得
     *
     * @return void
     */
    public function disassembledProjects()
    {
        return $this->hasMany('App\Project')->where('project_type', config('const.project.type.disassembled'));
    }

    /**
     * 架設案件を取得
     *
     * @return void
     */
    public function erectionProjects()
    {
        return $this->hasMany('App\Project')->where('project_type', config('const.project.type.erection'));
    }
}
