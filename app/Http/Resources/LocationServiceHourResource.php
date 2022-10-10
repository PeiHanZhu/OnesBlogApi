<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationServiceHourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'location_id' => $this->location_id,
            'opened_at' => $this->opened_at,
            'closed_at' => $this->closed_at,
            'weekday' => $this->weekday,
        ];
    }
}
