<?php

namespace App\Http\Resources;

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
            'user_id' => $this->user_id,
            'city_area_id' => $this->city_area_id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'avgScore' => $this->avgScore,
            'introduction' => Str::limit($this->introduction, 20),
            'active' => $this->active,
            'images' => array_map(function ($filePath) {
                return url(Storage::url($filePath));
            }, $this->images ?? []),
        ];
    }
}
