<?php

use Carbon\Carbon;

//hien thi tien
function printMoney($value)
{
    return number_format($value) . ' đ';
}
//hien thi thoi gian viet nam
function timeForHumans($time)
{
    $time = strtotime($time);
    $temp = date('a', $time);
    $time = date('H ', $time);
    return $time . ($temp == 'am' ? 'Giờ sáng' : 'Giờ chiều');
}

function getTimeLaravel($timeJson)
{
    $time = new Carbon($timeJson);
    $time->setTimezone(config('app.timezone'));
    return $time->toDateTimeString();
}

function getPriceOrder($arrTimeMain, $arrDateTimeCheck, $price_per_hour, $price_per_peak_hour)
{
    $arr = [];
    //dd($arrDateTimeCheck);
    $dateTimeStart = new Carbon($arrDateTimeCheck['start_at']);
    $dateTimeStart->setTimezone(config('app.timezone'));
    $dateTimeEnd = new Carbon($arrDateTimeCheck['end_at']);
    $dateTimeEnd->setTimezone(config('app.timezone'));


    //peak_hour
    $timeMainStart = new Carbon($dateTimeStart->format('Y-m-d H:i:s'));
    $time = explode(':', $arrTimeMain['time_start']);
    $timeMainStart->setTime($time[0], $time[1], $time[2]);
    $timeMainEnd = new Carbon($dateTimeEnd->format('Y-m-d H:i:s'));
    $time = explode(':', $arrTimeMain['time_end']);
    $timeMainEnd->setTime($time[0], $time[1], $time[2]);
    //dd($timeMainEnd->diffInhours($timeMainStart, false));

    //dd($dateTimeEnd->diffInhours($timeMainEnd, false));
    $start = $dateTimeStart;
    $end = $dateTimeEnd;
    if ($dateTimeEnd->diffInhours($timeMainEnd, false) < 0) {
        $end = $timeMainEnd;
    }
    if ($dateTimeStart->diffInHours($timeMainStart, false) >= 0) {
        $start = $timeMainStart;
    }
    $peak_hour = ($start->diffInHours($end, false) > 0) ? $start->diffInHours($end, false) : 0;
    $hour = $dateTimeStart->diffInMinutes($dateTimeEnd, false) / 60;
    return $peak_hour * $price_per_peak_hour + ($hour - $peak_hour) * $price_per_hour;
}
