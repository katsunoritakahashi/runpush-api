<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class FacadeS3Helper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'S3Helper';
    }
}
