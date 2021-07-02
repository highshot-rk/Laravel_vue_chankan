<?php

namespace App\Http\Resources;

use App\Sms;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SmsResource extends ResourceCollection
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
            'count' => $this->collection->count(),
            'price' => $this->collection->count() * Sms::PRICE_UNIT,
        ];
    }
}
