<?php

namespace App\Http\Resources;

class UserResource extends BaseResource
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
            'uid' => $this->uid,
            'deviceToken' => $this->device_token,
            'characterId' => $this->character_id,
            'endAt' => $this->end_at,
            'email' => $this->email,
        ];
    }
}
