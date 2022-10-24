<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
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
            'id' => $this->id,
            'user' => $this->user,
            'location' => $this->location,
            'title' => $this->title,
            'content' => Str::limit($this->content, 50),
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'active' => $this->active,
            'slug' => $this->slug,
            'images' => array_map(function ($filePath) {
                return url(Storage::url($filePath));
            }, $this->images ?? []),
        ];
    }
}
