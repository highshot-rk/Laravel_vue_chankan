<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ContractResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($item) {
            return [
                'advertisement_id'  => $item->advertisement_id,
                'period'            => $item->period,
                'schedule_ended_at' => $item->scheduleEndedAt(),
                'price'             => $item->priceWithUnit(),
                'started_at'        => $item->startedAt(),
                'ended_at'          => $item->endedAt(),
                'approve_at'        => $item->approveAt(),
            ];
        });
    }
}
