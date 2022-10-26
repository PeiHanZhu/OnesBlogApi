<?php

namespace App\Http\Resources;

use App\Models\City;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocationResource extends JsonResource
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
            'id' => $this->id,
            'user' => $this->user,
            'city_area_id' => $this->city_area_id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'city_and_area' => $this->cityArea->city->city . $this->cityArea->city_area,
            'address' => $this->address,
            'phone' => $this->phone,
            'avgScore' => $this->avgScore,
            'introduction' => $this->introduction,
            'active' => $this->active,
            'images' => array_map(function ($filePath) {
                return url(Storage::url($filePath));
            }, $this->images ?? []),
        ];
    }
}
