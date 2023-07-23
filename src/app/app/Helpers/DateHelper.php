<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * 今日から何日前かを返す
     */
    public static function CalculateDayAgo($dateTime): string
    {
        $diffDays = Carbon::parse($dateTime)->startOfDay()->diffInDays(Carbon::today());
        switch ($diffDays) {
            case 0:
                $result = '今日';
                break;
            case 1:
                $result = '昨日';
                break;
            case ($diffDays > 1 && $diffDays <= 7):
                $result = $diffDays . '日前';
                break;
            case ($diffDays > 7 && $diffDays <= 30):
                $result = floor($diffDays / 7) . '週前';
                break;
            case ($diffDays > 30):
                $result = floor($diffDays / 30) . 'ヶ月前';
                break;
            default:
                $result = '-';
                break;
        }
        return $result;
    }
}
