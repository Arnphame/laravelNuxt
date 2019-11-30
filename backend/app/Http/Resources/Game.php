<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;

class Game extends JsonResource
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
          'id' => $this->id,
          'location' => $this->location,
          'start_at' => $this->start_at,
          'status' => $this->status,
          'players' => UserResource::collection($this->users),
        ];
    }
}
