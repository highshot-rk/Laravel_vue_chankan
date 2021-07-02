<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectLabelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'projects' => $this->projects->map(function($item) {
                return [
                    'id'                          => $item->id,
                    'project_type'                => $item->project_type,
                    'work_on'                     => $item->work_on,
                    'work_on_date'                => $item->work_on ? $item->work_on->format('Y-m-d') : '--',
                    'work_on_string'              => $item->workOn(),
                    'time_type'                   => $item->time_type,
                    'scheduled_arrival_time_from' => $item->scheduled_arrival_time_from,
                    'scheduled_arrival_time_to'   => $item->scheduled_arrival_time_to,
                ];
            })
        ];
    }
}
