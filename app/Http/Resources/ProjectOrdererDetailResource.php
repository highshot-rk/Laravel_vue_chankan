<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectOrdererDetailResource extends JsonResource
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
            'id'                 => $this->id,
            'user'               => $this->user,
            'company'            => $this->company,
            'company_kana'       => $this->company_kana,
            'zip'                => $this->zip,
            'address'            => $this->address,
            'president'          => $this->president,
            'president_kana'     => $this->president_kana,
            'tel'                => $this->tel,
            'fax'                => $this->fax,
            'phone'              => $this->phone,
            'email'              => $this->email,
            'remark'             => $this->remark,
            'created_at'         => $this->created_at,
            'updated_at'         => $this->updated_at,
            'has_project'        => count($this->projects) > 0 ? true : false,
        ];
    }
}
