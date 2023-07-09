<?php

namespace App\Console\Commands;

use App\Mail\ReminderEmail;
use App\Models\Interpretation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Mail;

class SendReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to interpreters';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $timezone = env('TIMEZONE', "America/Denver");
        $currentDateTime = Carbon::now()->timezone($timezone);
        $currentDateTimeMinusOneHour = $currentDateTime->copy()->subHours(1);

        // Test

        Mail::raw('This is the email content', function ($message) {
            $message->from(env('ADMIN_EMAIL_DEV'), 'Nixons');
            $message->to('miksmth502@gmail.com');
            $message->subject('Test');
        });


        $interpretations = Interpretation::where('is_reminder_on', 1)
            ->where('reminder_email_sent', 0)
            ->whereDate('interpretationDate', $currentDateTime->toDateString())
            ->where(\DB::raw("HOUR(start_time)"), '>', $currentDateTimeMinusOneHour->format('H'))
            ->where(\DB::raw("HOUR(start_time)"), '<=', $currentDateTime->copy()->addHour()->format('H'))
            ->get();
        \Log::debug('Number of interpretations: ' . $interpretations->count());
        foreach ($interpretations as $interpretation) {
            // Send email to the interpreter
            if (isset($interpretation->interpreter) && $interpretation->interpreter->id != -1) {
                \Log::debug('Sending reminder email to: ' . $interpretation->interpreter->email);
                Mail::to($interpretation->interpreter->email)->send(new ReminderEmail($interpretation));
                $interpretation->reminder_email_sent = 1;
                $interpretation->save();
            }
        }
        return Command::SUCCESS;
    }
}