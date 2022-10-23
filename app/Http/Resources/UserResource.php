<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->loadMissing(['location' => function ($query) {
            $query->where('active', true);
        }]);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'login_type_id' => $this->login_type_id,
            'location' => $this->location,
            'token' => $this->token,
        ];
    }
}
