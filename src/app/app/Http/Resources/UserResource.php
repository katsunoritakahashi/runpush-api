<?php

namespace App\Http\Resources;

use App\Facades\FacadeS3Helper;

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
            'id' => $this->id,
            'familyName' => $this->family->name,
            'userName' => $this->name,
            'position' => $this->position->name,
            'email' => $this->email,
            'iconUrl' => FacadeS3Helper::getFilePublic($this->user_icon_url),
        ];
    }
}
