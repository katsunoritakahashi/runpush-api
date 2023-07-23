<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    const RANTEKUN = 1;
    const HISAJU = 2;
    const PHARAOH = 3;


    public function messages()
    {
        return $this->hasMany('App\Models\CharacterMessage');
    }
}
