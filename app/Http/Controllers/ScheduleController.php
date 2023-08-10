<?php

namespace App\Http\Controllers;

use App\Mail\ReminderEmail;
use App\Models\Interpretation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;

class ScheduleController extends Controller
{
    public function sendEmail()
    {
        $timezone = env('TIMEZONE', "America/Los_Angles");
        $currentDateTime = Carbon::now()->timezone($timezone);
        $currentDateTimeMinusOneHour = $currentDateTime->copy()->subHours(1);

        // Test
        if (env('TEST_SCHEDULE') == 1) {
            Mail::raw('It works', function ($message) {
                $message->from(env('ADMIN_EMAIL_DEV'), 'Nixons');
                $message->to('miksmth502@gmail.com');
                $message->subject('Test Schedule Email');
            });
        }


        \DB::enableQueryLog(); // Enable query log

        $interpretationIds = [];
        $nextHour = $currentDateTime->copy()->addHour();
        // $interpretations = Interpretation::where('is_reminder_on', 1)
        //     ->where('reminder_email_sent', 0)
        //     ->whereDate('interpretationDate', $currentDateTime->toDateString())
        //     ->whereTime('start_time', '>', $currentDateTime->toTimeString())
        //     ->whereTime('start_time', '<', $nextHour->toTimeString())
        //     // ->where(\DB::raw("HOUR(start_time)"), '>', $currentDateTime->format('H'))
        //     // ->where(\DB::raw("HOUR(start_time)"), '<', $currentDateTime->copy()->addHour()->format('H'))
        //     ->whereHas('interpreter')
        //     ->get();

        $currentDate = $currentDateTime->toDateString();
        $startTimeLowerBound1 = $currentDateTimeMinusOneHour->format('H:i:s');
        $startTimeUpperBound1 = '23:59:59';
        $startTimeLowerBound2 = '00:00:00';
        $startTimeUpperBound2 = $currentDateTime->copy()->addHour()->format('H:i:s');

        $interpretations = Interpretation::where('is_reminder_on', 1)
            ->where('reminder_email_sent', 0)
            ->whereDate('interpretationDate', $currentDate)
            ->where(function ($query) use ($startTimeLowerBound1, $startTimeUpperBound1, $startTimeLowerBound2, $startTimeUpperBound2) {
                $query->whereBetween(\DB::raw('time(start_time)'), [$startTimeLowerBound1, $startTimeUpperBound1])
                    ->orWhereBetween(\DB::raw('time(start_time)'), [$startTimeLowerBound2, $startTimeUpperBound2]);
            })
            ->whereHas('interpreter')
            ->get();


        $log = \DB::getQueryLog(); // Get the query log
        $lastQuery = end($log); // Get the last executed query
        foreach ($interpretations as $interpretation) {
            if ($interpretation->interpreter->id != -1) {
                \Log::debug('Sending reminder email to: ' . $interpretation->interpreter->email);
                Mail::to($interpretation->interpreter->email)->queue(new ReminderEmail($interpretation));
                $interpretationIds[] = $interpretation->id;
            }
        }

        if (!empty($interpretationIds)) {
            Interpretation::whereIn('id', $interpretationIds)->update(['reminder_email_sent' => 1]);
        }
        //fetch all interpretations with is_reminder_on = 1
        $interpretations = Interpretation::where('is_reminder_on', 1)->get();

        // Get interpretations with reminder_email_sent = 1
        $interpretationsSent = Interpretation::where('reminder_email_sent', 1)->get();


        return view('utils.remind-email-status', compact('interpretationIds', 'lastQuery', 'interpretationsSent', 'currentDateTime', 'currentDateTimeMinusOneHour', 'timezone', 'interpretations'));
    }
}