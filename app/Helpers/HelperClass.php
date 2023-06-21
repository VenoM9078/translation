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

    public static function storeLog()
    {

        /*
        2023-06-10 22:02 - Yuan - Created Order
        2023-06-11 12:23 - Silvia - Sent Quote
        2023-06-12 11:12 - Yuan - Approved Quote
        2023-06-13 08:30 - Silvia - Assigned Interpreter
        2023-06-13 10:00 - Jen -Declined Interpretation
        2023-06-16 10:20 - Silvia -Assigned Interpreter
        2023-06-16 13:31 - Jack - Confirmed Interpretation
        2023-06-18 15:00 - Jack - Reported Interpretation Time
        2023-06-20 22:03 - Silvia - Paid Interpreter (to be implemented in phase 3)
        */

    }
}

?>