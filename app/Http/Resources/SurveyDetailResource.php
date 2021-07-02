<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SurveyDetailResource extends JsonResource
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
            'id'                         => $this->id,
            'project_label'              => $this->projectLabel,
            'is_send_to_project_orderer' => $this->is_send_to_project_orderer,
            'remark'                     => $this->remark,
            'url'                        => $this->url,
            'survey_images'              => $this->surveyImages,
        ];
    }
}
