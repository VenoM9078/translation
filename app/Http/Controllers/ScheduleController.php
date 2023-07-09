<?php

namespace App\Http\Controllers;

use App\Mail\ReminderEmail;
use App\Models\Interpretation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;

class ScheduleController extends Controller
{
    public function sendEmail(){
        $timezone = env('TIMEZONE', "America/Denver");
        $currentDateTime = Carbon::now()->timezone($timezone);
        $currentDateTimeMinusOneHour = $currentDateTime->copy()->subHours(1);

        // Test
        if(env('TEST_SCHEDULE') == 1){
            Mail::raw('It works', function ($message) {
                $message->from(env('ADMIN_EMAIL_DEV'), 'Nixons');
                $message->to('miksmth502@gmail.com');
                $message->subject('Test Schedule Email');
            });
        }


        $interpretationIds = [];

        Interpretation::where('is_reminder_on', 1)
            ->where('reminder_email_sent', 0)
            ->whereDate('interpretationDate', $currentDateTime->toDateString())
            ->where(\DB::raw("HOUR(start_time)"), '>', $currentDateTimeMinusOneHour->format('H'))
            ->where(\DB::raw("HOUR(start_time)"), '<=', $currentDateTime->copy()->addHour()->format('H'))
            ->whereHas('interpreter')
            ->chunk(200, function ($interpretations) use (&$interpretationIds) {
                foreach ($interpretations as $interpretation) {
                    if ($interpretation->interpreter->id != -1) {
                        \Log::debug('Sending reminder email to: ' . $interpretation->interpreter->email);
                        Mail::to($interpretation->interpreter->email)->queue(new ReminderEmail($interpretation));
                        $interpretationIds[] = $interpretation->id;
                    }
                }
            });
        if (!empty($interpretationIds)) {
            Interpretation::whereIn('id', $interpretationIds)->update(['reminder_email_sent' => 1]);
        }
        return view('utils.remind-email-status',compact('interpretationIds'));
    }
}
