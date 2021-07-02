<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectDetailResource extends JsonResource
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
            'id'                          => $this->id,
            'label'                       => (new ProjectLabelResource($this->projectLabel)),
            'user'                        => (new UserDetailResource($this->user)),
            'project_orderer'             => $this->projectOrderer,
            'name'                        => $this->name,
            'charge'                      => $this->charge,
            'survey'                      => $this->projectLabel->survey,
            'work_on_string'              => $this->workOn(),
            'work_on_date'                => $this->work_on ? $this->work_on->format('Y-m-d') : '--',
            'work_on'                     => $this->work_on,
            'zip'                         => $this->zip,
            'address'                     => $this->address,
            'tel'                         => $this->tel,
            'project_type'                => $this->project_type,
            'project_type_name'           => $this->projectTypeName(),
            'time_type'                   => $this->time_type,
            'time_type_name'              => $this->timeTypeName(),
            'scheduled_arrival_time_from' => $this->scheduled_arrival_time_from,
            'scheduled_arrival_time_to'   => $this->scheduled_arrival_time_to,
            'road'                        => $this->road,
            'road_name'                   => $this->roadName(),
            'remark'                      => $this->remark,
            'last_messaged_at'            => $this->lastMessagedAt(),
            'is_notified'                 => $this->is_notified,
            'notified_at'                 => $this->notifiedAt(),
            'is_surveyed'                 => $this->is_surveyed,
            'surveyed_at'                 => $this->surveyedAt(),
            'is_started'                  => $this->is_started,
            'started_at'                  => $this->startedAt(),
            'is_finished'                 => $this->is_finished,
            'finished_at'                 => $this->finishedAt(),
            'created_at'                  => $this->createdAt(),
            'finish_img'                  => $this->finish_img,
            'url'                         => $this->url,
            'is_send_to_user'             => $this->is_send_to_user,
            'is_send_to_charge'           => $this->is_send_to_charge,
            'worker'                      => $this->worker,
            'process_color_id'            => $this->process_color_id,
        ];
    }
}
