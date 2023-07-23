<?php

namespace App\Http\Requests;

class UserRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'uid' => 'required|string|max:100',
            'deviceToken' => 'required|string|max:200',
            'characterId' => 'required|exists:characters.id',
            'endAt' => 'required',
        ];
    }
}
