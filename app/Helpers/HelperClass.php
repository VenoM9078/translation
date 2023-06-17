<?php
namespace App\Helpers;

class HelperClass
{
    public static function convertDateToCurrentTimeZone($date, $ip)
    {
        // dd($date);
        $json = file_get_contents("http://ip-api.com/json/");
        $data = json_decode($json);
        $timezone = $data->timezone;
        return $date->timezone($timezone);
    }

    public static function convertTimeToCurrentTimeZone($time, $ip)
    {
        $json = file_get_contents("http://ip-api.com/json/");
        $data = json_decode($json);
        $timezone = $data->timezone;
        $carbonTime = \Carbon\Carbon::parse($time);
        return $carbonTime->timezone($timezone)->format('h:m:s');
    }
}

?>