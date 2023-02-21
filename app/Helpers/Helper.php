<?php
function printMoney($value)
{
    return number_format($value) . ' đ';
}

function timeForHumans($time)
{
    $time = strtotime($time);
    $temp = date('a', $time);
    //dd($temp);
    $time = date('H ', $time);
    return $time . ($temp == 'am' ? 'Giờ sáng' : 'Giờ chiều');
}