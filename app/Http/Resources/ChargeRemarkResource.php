<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChargeRemarkResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id'             => $item->id,
                'user'           => $item->user,
                'charge'         => $item->charge,
                'work_on_string' => $item->workOn(),
                'work_on_date'   => $item->work_on ? $item->work_on->format('Y-m-d') : '--',
                'work_on'        => $item->work_on,
                'time_type'      => $item->time_type,
                'time_type_name' => $item->timeTypeName(),
                'remarks'        => $item->remarks,
            ];
        });
            // return [
            //     'id'         => $item->id,
            //     'status'     => $item->status,
            //     'company'    => $item->company,
            //     'url'        => $item->url,
            //     'img_url'    => $item->img_url,
            //     'tel'        => $item->tel,
            //     'charge'     => $item->charge,
            //     'email'      => $item->email,
            //     'phone'      => $item->phone,
            //     'zip'        => $item->zip,
            //     'address'    => $item->address,
            //     'manager'    => $item->manager,
            //     'contract'   => [
            //         'period'            => $item->contract->period,
            //         'schedule_ended_at' => $item->contract->scheduleEndedAt(),
            //         'price'             => $item->contract->price,
            //         'started_at'        => $item->contract->startedAt(),
            //         'ended_at'          => $item->contract->endedAt(),
            //         'approve_at'        => $item->contract->approveAt()
            //     ],
            //     'contracts'  => $item->contracts->map(function ($subItem) {
            //         return [
            //             'period'            => $subItem->period,
            //             'schedule_ended_at' => $subItem->scheduleEndedAt(),
            //             'price'             => $subItem->price,
            //             'started_at'        => $subItem->startedAt(),
            //             'ended_at'          => $subItem->endedAt(),
            //             'approve_at'        => $subItem->approveAt()
            //         ];
            //     }),
            // ];
    }
}
