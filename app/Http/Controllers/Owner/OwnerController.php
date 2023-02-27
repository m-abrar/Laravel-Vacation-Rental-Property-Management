<?php
namespace App\Http\Controllers\Owner;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
class OwnerController extends Controller
{
    //Admin panel dashboard
    public function dashboard()
    {
        $settings              = Settings::find(1);
        $user                  = \Auth::user();
        if($user->is_active = 0){
            die('Your account has been disabled by admin');
        }

        
        $notifications         = OwnerController::notifications();
        $properties            = Properties::select('id')->where('user_id', \Auth::user()->id)->get()->toArray();
        $reservations          = Reservations::select('id')->whereIn('property_id', $properties)->get()->toArray();
        


        $bookings              = count(Reservations::whereIn('property_id', $properties)->where('is_seen', '0')->where('date_start', '>=', date('Y-m-d'))->get());
        $arrivals              = count(Reservations::whereIn('property_id', $properties)->where('status', 'booked')->where('date_start', '>=', date('Y-m-d'))->get());
        $departures            = count(Reservations::whereIn('property_id', $properties)->where('status', 'booked')->where('date_end', '<=', date('Y-m-d'))->get());
        $transactions          = count(Transactions::whereIn('reservation_id', $reservations)->where('status', 'paid')->get());
        $dashboard             = (object) array(
            'bookings' => $bookings,
            'transactions' => $transactions,
            'arrivals' => $arrivals,
            'departures' => $departures
        );
        $reservations_new      = Reservations::whereIn('property_id', $properties)->where('is_seen', '0')->where('date_start', '>=', date('Y-m-d'))->orderBy('created_at', 'desc')->take(5)->get();
        $arrivals              = Reservations::whereIn('property_id', $properties)->where('date_start', '>=', date('Y-m-d'))->orderBy('date_start', 'asc')->take(5)->get();
        $departures            = Reservations::whereIn('property_id', $properties)->where('date_end', '<=', date('Y-m-d'))->orderBy('date_end', 'desc')->take(5)->get();
        $transactions_received = Transactions::whereIn('reservation_id', $reservations)->where('status', 'paid')->orderBy('date_paid', 'desc')->take(5)->get();
        $transactions_coming   = Transactions::whereIn('reservation_id', $reservations)->where('status', 'pending')->orderBy('date_due', 'asc')->take(5)->get();
        $js                    = "$('#treeview-business').addClass('active');\n";
        return view('owner.dashboard')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('dashboard', $dashboard)->with('reservations_new', $reservations_new)->with('transactions_received', $transactions_received)->with('transactions_coming', $transactions_coming)->with('arrivals', $arrivals)->with('departures', $departures)->with('js', $js);
    }
    //Prepare the notifcations to show in the admin panel.
    public function notifications()
    {
        $properties    = Properties::select('id')->where('user_id', \Auth::user()->id)->get()->toArray();
        $reservations  = Reservations::select('id')->whereIn('property_id', $properties)->get()->toArray();
        $bookings     = Reservations::whereIn('property_id', $properties)->where('is_seen', '0')->where('date_start', '>=', date('Y-m-d'))->orderBy('created_at', 'desc')->get();
        $arrivals = Reservations::whereIn('property_id', $properties)->whereBetween('date_start', [date('Y-m-d'),date('Y-m-d',strtotime("+1 month"))])->orderBy('date_start', 'asc')->get();
        
        $transactions = Transactions::whereIn('reservation_id', $reservations)->where('date_paid', '<=', date('Y-m-d H:i:s'))->orderBy('date_paid', 'desc')->orderBy('date_due', 'desc')->get();
        return $array = (object) array(
            'bookings' => $bookings,
            'arrivals' => $arrivals,
            'transactions' => $transactions
        );
    }
    
}
