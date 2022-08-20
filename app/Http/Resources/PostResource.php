<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostResource extends JsonResource
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
            'created_at' => $this->created_at,
            'user' => $this->user,
            'location_id' => $this->location_id,
            'title' => $this->title,
            'content' => Str::limit($this->content, 50),
            'published_at' => $this->published_at,
            'slug' => $this->slug,
        ];
    }
}
