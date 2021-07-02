<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChargeResource extends ResourceCollection
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
                'id'         => $item->id,
                'user'       => $item->user,
                'name'       => $item->name,
                // 'sort'       => $item->sort,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });
    }
}
