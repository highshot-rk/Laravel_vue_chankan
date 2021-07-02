<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
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
            'name'               => $this->name,
            'email'              => $this->email,
            'phone'              => $this->phone,
            'company'            => $this->company,
            'prefecture'         => $this->prefecture,
            'charges'            => $this->charges,
            'manager'            => $this->manager,
            'last_logined_at'    => $this->last_logined_at,
            'created_at'         => $this->created_at,
            'updated_at'         => $this->updated_at,
            'deleted_at'         => $this->deleted_at,
            'is_active'          => $this->is_active,
            'enable_sms'         => $this->enable_sms,
        ];
    }
}