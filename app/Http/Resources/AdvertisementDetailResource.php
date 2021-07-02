<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementDetailResource extends JsonResource
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
            'status'             => $this->status,
            'company'            => $this->company,
            'url'                => $this->url,
            'tel'                => $this->tel,
            'charge'             => $this->charge,
            'email'              => $this->email,
            'phone'              => $this->phone,
            'zip'                => $this->zip,
            'address'            => $this->address,
            'contracts'          => new ContractResource($this->contracts),
            'created_at'         => $this->created_at,
            'updated_at'         => $this->updated_at,
        ];
    }
}
