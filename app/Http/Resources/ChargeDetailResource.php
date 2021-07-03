<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChargeDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(is_countable($this->projects)) {
            return [
                'id'                 => $this->id,
                'user'               => $this->user,
                'is_parent'          => $this->is_parent,
                'name'               => $this->name,
                'phone'              => $this->phone,
                'edit_type'          => $this->edit_type,
                'created_at'         => $this->created_at,
                'updated_at'         => $this->updated_at,
                'has_project'        => count($this->projects) > 0 ? true : false,
            ];
        } else {
            return [
                'id'                 => $this->id,
                'user'               => $this->user,
                'is_parent'          => $this->is_parent,
                'name'               => $this->name,
                'phone'              => $this->phone,
                'edit_type'          => $this->edit_type,
                'created_at'         => $this->created_at,
                'updated_at'         => $this->updated_at,
                'has_project'        => false,
            ];   
        }
    }
}