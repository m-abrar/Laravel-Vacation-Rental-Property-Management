<?php
namespace App\Http\Controllers;
use Mail;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class SendEmailsController extends Controller
{
    //Call this function for sending email to property owner /admin when a buying offer is posted.
    public function buyingOffer($id)
    {
        $buyingoffer    = \App\BuyingOffers::where('id', $id)->first();

        $property             = $buyingoffer->property->title;
        $property_owner_email             = $buyingoffer->property->owner->email;
        $property_owner_firstname             = $buyingoffer->property->owner->firstname;
        $property_owner_lastname             = $buyingoffer->property->owner->lastname;
        $first_name            = $buyingoffer->firstname;
        $last_name             = $buyingoffer->lastname;
        $buyer_email = $buyingoffer->email;
        $message         = $buyingoffer->message;
        $search_array = array(
            '[owner_first_name]',
            '[owner_last_name]',
            '[property]',
            '[first_name]',
            '[last_name]',
            '[email]',
            '[message]',
            '[site_name]'
        );
        $replace_array = array(
            $property_owner_firstname,
            $property_owner_lastname,
            $property,
            $first_name,
            $last_name,
            $buyer_email,
            $message,
            \App\Settings::find(1)->site_title
        );
        $emailtemplate = \App\EmailTemplates::where('id', 201)->first();
        $subject       = str_replace($search_array, $replace_array, $emailtemplate->email_subject);
        $message       = str_replace($search_array, $replace_array, $emailtemplate->email_body);
        $message       = html_entity_decode(stripslashes($message));
        ///Email Function
        if(Mail::send([], [], function($mail) use ($subject, $message, $buyer_email) {
        $mail->from(trim(\App\Settings::find(1)->site_email), \App\Settings::find(1)->site_title);
        $mail->to($buyer_email)->cc(trim(\App\Settings::find(1)->site_email));
        $mail->subject($subject);
        $mail->setBody($message, 'text/html');
        })){
        return true;
        }else{
        return false;
        }
    }

    //Call this function for sending email to customer/admin when a reservation is successful.
    public function reservationSuccess($id)
    {
        $reservation    = \App\Reservations::where('id', $id)->first();
        $customer_email = $reservation->email;
        if (null === $customer_email)
            return false;
        $property             = $reservation->property->title;
        $firstname            = $reservation->firstname;
        $lastname             = $reservation->lastname;
        $date_start           = date('m/d/Y', strtotime($reservation->date_start));
        $date_end             = date('m/d/Y', strtotime($reservation->date_end));
        $nights               = intval((strtotime($reservation->date_end) - strtotime($reservation->date_start)) / 86400);
        $total_amount         = $reservation->total_amount;
        $booking_status       = ucwords($reservation->status);
        $transactions_history = 'Transaction History:<br/>';
        $transactions         = \App\Transactions::where('reservation_id', $reservation->id)->get();
        $counter              = 1;
        foreach ($transactions as $transaction) {
            $transactions_history .= "
                        <ul>
                        <li>(" . $counter . "/" . count($transactions) . ")</li>
                        <li>Term of Deposit: " . ucwords($transaction->deposit_term) . "</li>
                        <li>Amount: $" . $transaction->amount . "</li>
                        <li>Date Due: " . date('m/d/Y', strtotime($transaction->date_due)) . "</li>
                        <li>Status: " . ucwords($transaction->status) . "</li>
                        </ul>";
            $counter++;
        } //$transactions as $transaction
        $search_array = array(
            '[customer_email]',
            '[first_name]',
            '[last_name]',
            '[date_arrival]',
            '[date_departure]',
            '[nights]',
            '[property]',
            '[transactions_history]',
            '[amount_total]',
            '[booking_status]',
            '[site_name]'
        );
        $transactions_history .= '<br/><br/>';
        $replace_array = array(
            $customer_email,
            $firstname,
            $lastname,
            $date_start,
            $date_end,
            $nights,
            $property,
            $transactions_history,
            $total_amount,
            $booking_status,
            \App\Settings::find(1)->site_title
        );
        $emailtemplate = \App\EmailTemplates::where('id', 1)->first();
        $subject       = str_replace($search_array, $replace_array, $emailtemplate->email_subject);
        $message       = str_replace($search_array, $replace_array, $emailtemplate->email_body);
        $message       = html_entity_decode(stripslashes($message));
        ///Email Function
        if(Mail::send([], [], function($mail) use ($subject, $message, $customer_email) {
        $mail->from(trim(\App\Settings::find(1)->site_email), \App\Settings::find(1)->site_title);
        $mail->to($customer_email)->cc(trim(\App\Settings::find(1)->site_email));
        $mail->subject($subject);
        $mail->setBody($message, 'text/html');
        })){
        return true;
        }else{
        return false;
        }
    }

    //Call this function to notify the owner of the property when a reservation is created.
    public function notifyOwner($id)
    {
        $reservation = \App\Reservations::where('id', $id)->first();
        $owner_email = @$reservation->property->owner->email;
        if (null === $owner_email)
            return false;
        $property       = $reservation->property->title;
        $firstname      = @$reservation->property->owner->firstname;
        $lastname       = @$reservation->property->owner->lastname;
        $date_start     = date('m/d/Y', strtotime($reservation->date_start));
        $date_end       = date('m/d/Y', strtotime($reservation->date_end));
        $nights         = intval((strtotime($reservation->date_end) - strtotime($reservation->date_start)) / 86400);
        $total_amount   = $reservation->total_amount;
        $booking_status = ucwords($reservation->status);
        $search_array   = array(
            '[first_name]',
            '[last_name]',
            '[date_arrival]',
            '[date_departure]',
            '[nights]',
            '[property]',
            '[booking_status]',
            '[site_name]'
        );
        $replace_array  = array(
            $firstname,
            $lastname,
            $date_start,
            $date_end,
            $nights,
            $property,
            $booking_status,
            \App\Settings::find(1)->site_title
        );
        $emailtemplate  = \App\EmailTemplates::where('id', 101)->first();
        $subject        = str_replace($search_array, $replace_array, $emailtemplate->email_subject);
        $message        = str_replace($search_array, $replace_array, $emailtemplate->email_body);
        $message        = html_entity_decode(stripslashes($message));
        ///Email Function
        if(Mail::send([], [], function($mail) use ($subject, $message, $owner_email) {
        $mail->from(trim(\App\Settings::find(1)->site_email), \App\Settings::find(1)->site_title);
        $mail->to($owner_email)->cc(trim(\App\Settings::find(1)->site_email));
        $mail->subject($subject);
        $mail->setBody($message, 'text/html');
        })){
        return true;
        }else{
        return false;
        }
    }
    //Call this function to notify the hosuekeeper of the property when a reservation is created.
    public function notifyHousekeeper($id)
    {
        $reservation       = \App\Reservations::where('id', $id)->first();
        $housekeeper_email = @$reservation->property->housekeeper->email;
        if (null === $housekeeper_email)
            return false;
        $property       = $reservation->property->title;
        $firstname      = @$reservation->property->housekeeper->firstname;
        $lastname       = @$reservation->property->housekeeper->lastname;
        $date_start     = date('m/d/Y', strtotime($reservation->date_start));
        $date_end       = date('m/d/Y', strtotime($reservation->date_end));
        $nights         = intval((strtotime($reservation->date_end) - strtotime($reservation->date_start)) / 86400);
        $total_amount   = $reservation->total_amount;
        $booking_status = ucwords($reservation->status);
        $search_array   = array(
            '[first_name]',
            '[last_name]',
            '[date_arrival]',
            '[date_departure]',
            '[nights]',
            '[property]',
            '[booking_status]',
            '[site_name]'
        );
        $replace_array  = array(
            $firstname,
            $lastname,
            $date_start,
            $date_end,
            $nights,
            $property,
            $booking_status,
            \App\Settings::find(1)->site_title
        );
        $emailtemplate  = \App\EmailTemplates::where('id', 102)->first();
        $subject        = str_replace($search_array, $replace_array, $emailtemplate->email_subject);
        $message        = str_replace($search_array, $replace_array, $emailtemplate->email_body);
        $message        = html_entity_decode(stripslashes($message));
        ///Email Function
        if(Mail::send([], [], function($mail) use ($subject, $message, $housekeeper_email) {
        $mail->from(trim(\App\Settings::find(1)->site_email), \App\Settings::find(1)->site_title);
        $mail->to($housekeeper_email)->cc(trim(\App\Settings::find(1)->site_email));
        $mail->subject($subject);
        $mail->setBody($message, 'text/html');
        })){
        return true;
        }else{
        return false;
        }
        
    }
    //Call this function to notify the maintenance vendor of the property when a reservation is created.
    public function notifyVendor($id)
    {
        $reservation  = \App\Reservations::where('id', $id)->first();
        $vendor_email = @$reservation->property->vendor->email;
        if (null === $vendor_email)
            return false;
        $property       = $reservation->property->title;
        $firstname      = @$reservation->property->vendor->firstname;
        $lastname       = @$reservation->property->vendor->lastname;
        $date_start     = date('m/d/Y', strtotime($reservation->date_start));
        $date_end       = date('m/d/Y', strtotime($reservation->date_end));
        $nights         = intval((strtotime($reservation->date_end) - strtotime($reservation->date_start)) / 86400);
        $total_amount   = $reservation->total_amount;
        $booking_status = ucwords($reservation->status);
        $search_array   = array(
            '[first_name]',
            '[last_name]',
            '[date_arrival]',
            '[date_departure]',
            '[nights]',
            '[property]',
            '[booking_status]',
            '[site_name]'
        );
        $replace_array  = array(
            $firstname,
            $lastname,
            $date_start,
            $date_end,
            $nights,
            $property,
            $booking_status,
            \App\Settings::find(1)->site_title
        );
        $emailtemplate  = \App\EmailTemplates::where('id', 103)->first();
        $subject        = str_replace($search_array, $replace_array, $emailtemplate->email_subject);
        $message        = str_replace($search_array, $replace_array, $emailtemplate->email_body);
        $message        = html_entity_decode(stripslashes($message));
        ///Email Function
        if(Mail::send([], [], function($mail) use ($subject, $message, $vendor_email) {
        $mail->from(trim(\App\Settings::find(1)->site_email), \App\Settings::find(1)->site_title);
        $mail->to($vendor_email)->cc(trim(\App\Settings::find(1)->site_email));
        $mail->subject($subject);
        $mail->setBody($message, 'text/html');
        })){
        return true;
        }else{
        return false;
        }
    }
}