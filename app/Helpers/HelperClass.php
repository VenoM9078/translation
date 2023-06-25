<?php
namespace App\Helpers;

use App\Models\ContractorLog;
use App\Models\InvoiceLogs;
use App\Models\Order;
use App\Models\OrderLog;
use Carbon\Carbon;

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


    public static function storeOrderLog(
        $is_admin = null,
        $user,
        $order_id,
        $model_name,
        $user_type,
        $action,
        $old_translation_status = null,
        $new_translation_status = null,
        $old_payment_status = null,
        $new_payment_status = null,
        $old_translation_sent_status = null,
        $new_translation_sent_status = null,
        $old_proofread_sent_status = null,
        $new_proofread_sent_status = null,
        $old_order_completed_status = null,
        $new_order_completed_status = null,
        $is_interpretation = null,
        $interpretation_status = null,
        $interpretation_id = null
    ) {



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

        $orderLog = new OrderLog();
        $orderLog->is_admin = $is_admin;
        $orderLog->user_id = $user;
        $orderLog->order_id = $order_id;
        $orderLog->user_type = $user_type;
        $orderLog->model_name = $model_name;
        $orderLog->action = $action;
        $orderLog->old_translation_status = $old_translation_status;
        $orderLog->new_translation_status = $new_translation_status;
        $orderLog->old_payment_status = $old_payment_status;
        $orderLog->new_payment_status = $new_payment_status;
        $orderLog->old_translation_sent_status = $old_translation_sent_status;
        $orderLog->new_translation_sent_status = $new_translation_sent_status;
        $orderLog->old_proofread_sent_status = $old_proofread_sent_status;
        $orderLog->new_proofread_sent_status = $new_proofread_sent_status;
        $orderLog->old_order_completed_status = $old_order_completed_status;
        $orderLog->new_order_completed_status = $new_order_completed_status;

        //interpretation
        if($is_interpretation != null){
            $orderLog->interpretation_id = $interpretation_id;
            $orderLog->is_interpretation = $is_interpretation;
            $orderLog->interpretation_status = $interpretation_status;
        }
        $orderLog->created_at = Carbon::now();
        
        $orderLog->save();

    }

    public static function storeContractorLog(
        $user = null,
        $is_admin = null,
        $order_id,
        $contractor_id,
        $model_name,
        $user_type,
        $contractor_type,
        $action,
        $old_translation_status = null,
        $new_translation_status = null,
        $is_accepted = null,
        $old_proof_read_sent_status = null,
        $new_proof_read_sent_status = null,
        $new_interpretation_sent_status = null,
        $old_interpretation_sent_status = null,
        $interpretation_id = null
    ) {
        $contractorLog = new ContractorLog();
        $contractorLog->user_id = $user; //admin id
        $contractorLog->contractor_id = $contractor_id;
        $contractorLog->is_admin = $is_admin;
        $contractorLog->user_type = $user_type;
        $contractorLog->order_id = $order_id;
        $contractorLog->contractor_type = $contractor_type;
        $contractorLog->model_name = $model_name;
        $contractorLog->action = $action;
        $contractorLog->old_translation_status = $old_translation_status;
        $contractorLog->new_translation_status = $new_translation_status;
        $contractorLog->is_accepted = $is_accepted;

        $contractorLog->old_proof_read_sent_status = $old_proof_read_sent_status;
        $contractorLog->new_proof_read_sent_status = $new_proof_read_sent_status;

        $contractorLog->new_interpretation_sent_status = $new_interpretation_sent_status;
        $contractorLog->old_interpretation_sent_status = $old_interpretation_sent_status;

        $contractorLog->interpretation_id = $interpretation_id;
        $contractorLog->created_at = Carbon::now();

        $contractorLog->save();
    }

    public static function storeInvoiceLogs(
        $user = null,
        $is_admin = null,
        $order_id = null,
        $model_name,
        $user_type,
        $action,
        $invoice_sent = null,
        $interpretation_id = null
    ) {

        $invoiceLog = new InvoiceLogs();
        $invoiceLog->user_id = $user;
        $invoiceLog->is_admin= $is_admin;
        $invoiceLog->user_id = $user;
        $invoiceLog->order_id = $order_id;
        $invoiceLog->user_type = $user_type;
        $invoiceLog->action = $action;
        $invoiceLog->invoice_sent = $invoice_sent;
        $invoiceLog->interpretation_id = $interpretation_id;
        $invoiceLog->created_at = Carbon::now();
        $invoiceLog->save();

    }
}

?>