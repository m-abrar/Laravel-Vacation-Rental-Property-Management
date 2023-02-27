<?php
namespace App\Http\Controllers;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NavigationController as Nav;
use Illuminate\Http\Request;

use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\ModelLocations;
use App\Models\PropertiesRates;
use App\Models\Calendar;


class SelectDatesController extends Controller
{
    //Shows the calendar with available and booked dates of a property
    //Included on the pages as a widget
    //Lets the user click available dates and make a selection.
    //The view page has jquery that calls relevant functions through ajax to calculate the lodging total and lineitems and other helpful information.
    public function selectDates($property, $year, $month, $pre_select_date_start = 'NA', $pre_select_date_end = 'NA', $reservation_id = '0')
    {
        $property_slug         = $property;
        $propertyResult        = Properties::where('slug', $property)->first();
        $property_title        = $propertyResult->title;
        $property_id           = $propertyResult->id;
        $loopYear              = $year;
        $loopMonth             = $month;
        $timestamp             = mktime(0, 0, 0, $month, 1, $year);
        $monthtotaldays        = date('t', $timestamp);
        $thismonth             = getdate($timestamp);
        $startday              = $thismonth['wday'];
        $calendarPreviousYear  = date('Y', strtotime("-1 month", strtotime($year . "-" . $month . "-01")));
        $calendarPreviousMonth = date('n', strtotime("-1 month", strtotime($year . "-" . $month . "-01")));
        $calendarNextYear      = date('Y', strtotime("+1 month", strtotime($year . "-" . $month . "-01")));
        $calendarNextMonth     = date('n', strtotime("+1 month", strtotime($year . "-" . $month . "-01")));
        $datesResult           = Calendar::where('reservation_id', $reservation_id)->get();
        $dates_editing         = array();
        foreach ($datesResult as $date) {
            array_push($dates_editing, $date->date);
        } //$datesResult as $date
        $datesResult    = Calendar::where('property_id', $property_id)->where('reservation_id', '!=', $reservation_id)->whereRaw("MONTH(date)='$month' AND YEAR(date)='$year'")->get();
        $dates_reserved = '';
        foreach ($datesResult as $date) {
            $dates_reserved['date_' . date('Ymd', strtotime($date->date))] = $date->status;
        } //$datesResult as $date
        if ($pre_select_date_start != 'NA' and $pre_select_date_end != 'NA') {
            SelectDatesController::saveDatesSearchedToSession($pre_select_date_start, $pre_select_date_end);
            if (\Session::has('dates_searched')) {
                $dates_searched = \Session::get('dates_searched');
            } //\Session::has('dates_searched')
        } //$pre_select_date_start != 'NA' and $pre_select_date_end != 'NA'
        elseif ($pre_select_date_start != 'NA' and $pre_select_date_end == 'NA') {
            SelectDatesController::saveDatesSearchedToSession($pre_select_date_start, $pre_select_date_start);
            if (\Session::has('dates_searched')) {
                $dates_searched = \Session::get('dates_searched');
            } //\Session::has('dates_searched')
        } //$pre_select_date_start != 'NA' and $pre_select_date_end == 'NA'
            elseif (\Session::has('dates_searched')) {
            $dates_searched = \Session::get('dates_searched');
        } //\Session::has('dates_searched')
        return view('include.calendar-select-dates')->with('property_id', $property_id)->with('dates_editing', $dates_editing)->with('dates_searched', @$dates_searched)->with('pre_select_date_start', $pre_select_date_start)->with('pre_select_date_end', $pre_select_date_end)->with('property_slug', $property_slug)->with('timestamp', $timestamp)->with('monthtotaldays', $monthtotaldays)->with('thismonth', $thismonth)->with('loopYear', $loopYear)->with('loopMonth', $loopMonth)->with('startday', $startday)->with('calendarPreviousYear', $calendarPreviousYear)->with('calendarPreviousMonth', $calendarPreviousMonth)->with('calendarNextYear', $calendarNextYear)->with('calendarNextMonth', $calendarNextMonth)->with('dates_reserved', $dates_reserved);
    }
    //Lets save the dates of arrival and departure to the session which a customer/admin has searched for booking to make the user interface great.
    public function saveDatesSearchedToSession($date1, $date2)
    {
        if (empty($date1) OR $date1 == '0' OR $date1 == 'NA' OR $date1 == 'mm/dd/yyyy' OR empty($date2) OR $date2 == '0' OR $date2 == 'NA' OR $date2 == 'mm/dd/yyyy') {
            return '1 Please click on the first and last date of your stay.<br />';
        } //empty($date1) OR $date1 == '0' OR $date1 == 'NA' OR $date1 == 'mm/dd/yyyy' OR empty($date2) OR $date2 == '0' OR $date2 == 'NA' OR $date2 == 'mm/dd/yyyy'
        if (date('Ymd', strtotime($date1)) < date('Ymd', strtotime($date2))) {
            $date_start = date('Y-m-d', strtotime($date1));
            $date_end   = date('Y-m-d', strtotime('+1 day', strtotime($date2)));
        } //date('Ymd', strtotime($date1)) < date('Ymd', strtotime($date2))
        else {
            $date_start = date('Y-m-d', strtotime($date2));
            $date_end   = date('Y-m-d', strtotime('+1 day', strtotime($date1)));
        }
        $dates_searched = array();
        while ($date_start != $date_end) {
            array_push($dates_searched, $date_start);
            $date_start = date("Y-m-d", strtotime("+1 day", strtotime($date_start)));
        } //$date_start != $date_end
        \Session::put('dates_searched', $dates_searched);
        //var_dump($dates_searched);
        return implode(',', $dates_searched);
    }
    // Checks for and shows the user a message about if a property is available for booking or already booked.
    public function bookingAvailabilityMessage($property, $date1, $date2, $reservation_id = '0')
    {
        if (empty($property) OR $property == '0') {
            return 'Please choose the property.<br />';
        } //empty($property) OR $property == '0'
        if (empty($date1) OR $date1 == '0' OR $date1 == 'NA' OR $date1 == 'mm/dd/yyyy' OR empty($date2) OR $date2 == '0' OR $date2 == 'NA' OR $date2 == 'mm/dd/yyyy') {
            return 'Please click on the first and last date of your stay.<br />';
        } //empty($date1) OR $date1 == '0' OR $date1 == 'NA' OR $date1 == 'mm/dd/yyyy' OR empty($date2) OR $date2 == '0' OR $date2 == 'NA' OR $date2 == 'mm/dd/yyyy'
        $propertyResult = Properties::where('slug', $property)->first();
        $property_title = $propertyResult->title;
        $property_id    = $propertyResult->id;
        if (date('Ymd', strtotime($date1)) < date('Ymd', strtotime($date2))) {
            $date_start = date('Y-m-d', strtotime($date1));
            $date_end   = date('Y-m-d', strtotime('+1 day', strtotime($date2)));
        } //date('Ymd', strtotime($date1)) < date('Ymd', strtotime($date2))
        else {
            $date_start = date('Y-m-d', strtotime($date2));
            $date_end   = date('Y-m-d', strtotime('+1 day', strtotime($date1)));
        }
        $message = '<div class="alert alert-success" id="booking-message-from-ajax">';
        $message .= '<strong>Property:</strong> ' . $property_title . '<br/>';
        $message .= '<strong>Arrival:</strong> ' . date('m/d/Y', strtotime($date_start)) . '<br/>';
        $message .= '<strong>Departure:</strong> ' . date('m/d/Y', strtotime($date_end)) . '<br/>';
        $message .= '</div>';
        $availabilityStatus = SelectDatesController::isPropertyAvailable($property_id, $date_start, $date_end, $reservation_id);
        if ($availabilityStatus !== true) {
            return '<div class="alert alert-danger"><strong>Sorry!</strong><br/>' . $availabilityStatus . '</div>';
        } //$availabilityStatus !== true
        return ($message);
    }
    //Calculates the total loding price for a property between two given dates
    //Because the system is designed to be stopped if calendar is booked, we send reservation_id to skip on calendar and continue searching.
    public function calculateLodgingPrice($property, $date1, $date2, $reservation_id = '0', $add_days = '0')
    {
        

        if (empty($property) OR $property == '0' OR $property == 'NA') {
            return 'Please choose the property.<br />';
        } //empty($property) OR $property == '0' OR $property == 'NA'
        if (empty($date1) OR $date1 == '0' OR $date1 == 'NA' OR $date1 == 'mm/dd/yyyy' OR empty($date2) OR $date2 == '0' OR $date2 == 'NA' OR $date2 == 'mm/dd/yyyy') {
            return 'Please click on the first and last date of your stay<br />';
        } //empty($date1) OR $date1 == '0' OR $date1 == 'NA' OR $date1 == 'mm/dd/yyyy' OR empty($date2) OR $date2 == '0' OR $date2 == 'NA' OR $date2 == 'mm/dd/yyyy'

        if (is_numeric($property)) {
            $propertyResult = Properties::where('id', $property)->first();

        } //is_int($property)
        else {
            $propertyResult = Properties::where('slug', $property)->first();

        }

        
            $property_title = $propertyResult->title;
            $property_id    = $propertyResult->id;
        
        if (date('Ymd', strtotime($date1)) < date('Ymd', strtotime($date2))) {
            $date_start = date('Y-m-d', strtotime($date1));
            $date_end   = date('Y-m-d', strtotime("+$add_days days", strtotime($date2)));
        } //date('Ymd', strtotime($date1)) < date('Ymd', strtotime($date2))
        else {
            $date_start = date('Y-m-d', strtotime($date2));
            $date_end   = date('Y-m-d', strtotime("+$add_days days", strtotime($date1)));
        }
        $availabilityStatus = SelectDatesController::isPropertyAvailable($property_id, $date_start, $date_end, $reservation_id);
        if ($availabilityStatus !== true) {
            return '0';
        } //$availabilityStatus !== true
        else {
            $error            = '';
            $total_price      = 0;
            $dates_difference = intval((strtotime($date_end) - strtotime($date_start)) / 86400);
            if ($dates_difference >= 28) {
                $pricetype = 'monthly';
            } //$dates_difference >= 28
            elseif ($dates_difference >= 14) {
                $pricetype = 'two_weekly';
            } //$dates_difference >= 14
                elseif ($dates_difference >= 7) {
                $pricetype = 'weekly';
            } //$dates_difference >= 7
            else {
                $pricetype = 'daily';
            }
            $propertyResult      = Properties::where('id', $property_id)->first();
            $property_id         = $propertyResult->id;
            $is_price_monthly    = $propertyResult->is_price_monthly;
            $is_price_two_weekly = $propertyResult->is_price_two_weekly;
            $is_price_weekly     = $propertyResult->is_price_weekly;
            $is_price_daily      = $propertyResult->is_price_daily;
            $price_monthly       = ($propertyResult->price_monthly / 28);
            $price_two_weekly    = ($propertyResult->price_two_weekly / 14);
            $price_weekly        = ($propertyResult->price_weekly / 7);
            $price_daily         = ($propertyResult->price_daily);
            $date_start_loop     = $date_start;
            $date_end_loop       = $date_end;
            while ($date_start_loop != $date_end_loop) {
                $date_in_db  = date('n-j', strtotime($date_start_loop));
                $ratesResult = PropertiesRates::where('property_id', $property_id)->where('date', $date_in_db)->first();
                if (count((array)$ratesResult) > '0') {
                    $is_price_monthly    = $ratesResult->is_price_monthly;
                    $is_price_two_weekly = $ratesResult->is_price_two_weekly;
                    $is_price_weekly     = $ratesResult->is_price_weekly;
                    $is_price_daily      = $ratesResult->is_price_daily;
                    $price_monthly       = ($ratesResult->price_monthly / 28);
                    $price_two_weekly    = ($ratesResult->price_two_weekly / 14);
                    $price_weekly        = ($ratesResult->price_weekly / 7);
                    $price_daily         = ($ratesResult->price_daily);
                } //count($ratesResult) > '0'
                if ($pricetype == 'monthly' AND $is_price_monthly == '1' AND !empty($price_monthly) AND $price_monthly != '0') {
                    $total_price += $price_monthly;
                } //$pricetype == 'monthly' AND $is_price_monthly == '1' AND !empty($price_monthly) AND $price_monthly != '0'
                elseif ($pricetype == 'two_weekly' AND $is_price_two_weekly == '1' AND !empty($price_two_weekly) AND $price_two_weekly != '0') {
                    $total_price += $price_two_weekly;
                } //$pricetype == 'two_weekly' AND $is_price_two_weekly == '1' AND !empty($price_two_weekly) AND $price_two_weekly != '0'
                    elseif ($pricetype == 'weekly' AND $is_price_weekly == '1' AND !empty($price_weekly) AND $price_weekly != '0') {
                    $total_price += $price_weekly;
                } //$pricetype == 'weekly' AND $is_price_weekly == '1' AND !empty($price_weekly) AND $price_weekly != '0'
                    elseif ($is_price_daily == '1' AND !empty($price_daily) AND $price_daily != '0') {
                    //we have not applied $pricetype == 'daily' in the if condition
                    //so that if admin has not provided monthly, two_weekly or weekly units of rates
                    //then the calcuation function picks daily price as the unit rate.
                    $total_price += $price_daily;
                } //$is_price_daily == '1' AND !empty($price_daily) AND $price_daily != '0'
                else {
                    $error .= 'No price for: ' . date('M d', strtotime($date_start_loop)) . '<br />';
                }
                $date_start_loop = date("Y-m-d", strtotime("+1 day", strtotime($date_start_loop)));
            } //$date_start_loop != $date_end_loop
            if (!empty($error)) {
                return 'Sorry we have an error here, please see the price table and make sure your search qualifies for minimum rental requirements or contact our office!<br /> ' . $error;
            } //!empty( $error )
            else {
                return $total_price;
            }
        }
    }
    //Reads the calendar for if the property is already booked for given dates ignoring the reservation id.
    function isPropertyAvailable($property_id = '', $date_start = '', $date_end = '', $reservation_id = '0')
    {
        $date_start    = date("Y-m-d", strtotime($date_start));
        $date_end      = date("Y-m-d", strtotime($date_end));
        $error         = '';
        $date_loop     = $date_start;
        $date_end_loop = $date_end;
        while ($date_loop != $date_end_loop) {
            $calendarResult = Calendar::where('property_id', $property_id)->where('date', $date_loop)->where('reservation_id', '!=', $reservation_id)->first();
            if (count((array)$calendarResult) > '0') {
                $error .= 'Not available for: ' . date('m/d/Y', strtotime($date_loop)) . ' (' . $calendarResult->status . ')<br />';
            } //count($calendarResult) > '0'
            $date_loop = date("Y-m-d", strtotime("+1 day", strtotime($date_loop)));
        } //$date_loop != $date_end_loop
        if (!empty($error)) {
            return $error;
        } //!empty( $error )
        else {
            return true;
        }
    }
    //Different seasons have different value of number of days of final payment before arrival.
    //This function finds the highest value from all the involved seasons in a reservation and subtracts from checkin date.
    public function calculateFinalPaymentDate($property_id = '', $date_start = '', $date_end = '')
    {
        //find out the highest possible value of number of days before arrival to charge balance payment through cronjob.
        $date_start    = $date_start_loop = date("Y-m-d", strtotime($date_start));
        $date_end      = $date_end_loop = date("Y-m-d", strtotime($date_end));
        
        $cronjob_dates = array();

        while ($date_start_loop != $date_end_loop) {

            

            $date_in_db = date('n-j', strtotime($date_start_loop));
            $rates      = PropertiesRates::where('property_id', $property_id)->where('date', $date_in_db)->first();

            $n = !empty($rates['final_payment_days'])?$rates['final_payment_days']:0;
            
            $cronjob_date = date("Y-m-d", strtotime("-$n days", strtotime($date_start_loop))); // use echo for development debugging
            array_push($cronjob_dates, $cronjob_date);
            $date_start_loop = date("Y-m-d", strtotime("+1 day", strtotime($date_start_loop))); // use echo for development debugging
        } //$date_start_loop != $date_end_loop
        //dd(__LINE__);
        return min($cronjob_dates);
    }
}
