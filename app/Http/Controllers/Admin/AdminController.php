<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\Categories;
use App\Models\ModelLocations;
use App\Models\PageTypes;
use App\Models\Transactions;
use App\Models\Reservations;

class AdminController extends Controller
{
    //Admin panel dashboard
    public function dashboard()
    {
        $settings              = Settings::find(1);
        $user                  = Auth::user();
        $notifications         = AdminController::notifications();
        $bookings              = count(Reservations::where('is_seen', '0')->where('date_start', '>=', date('Y-m-d'))->get());
        $arrivals              = count(Reservations::where('status', 'booked')->where('date_start', '>=', date('Y-m-d'))->get());
        $departures            = count(Reservations::where('status', 'booked')->where('date_end', '<=', date('Y-m-d'))->get());
        $transactions          = count(Transactions::where('status', 'paid')->get());
        $dashboard             = (object) array(
            'bookings' => $bookings,
            'transactions' => $transactions,
            'arrivals' => $arrivals,
            'departures' => $departures
        );
        $reservations_new      = Reservations::where('is_seen', '0')->where('date_start', '>=', date('Y-m-d'))->orderBy('created_at', 'desc')->take(5)->get();
        $arrivals              = Reservations::where('date_start', '>=', date('Y-m-d'))->orderBy('date_start', 'asc')->take(5)->get();
        $departures            = Reservations::where('date_end', '<=', date('Y-m-d'))->orderBy('date_end', 'desc')->take(5)->get();
        $transactions_received = Transactions::where('status', 'paid')->orderBy('date_paid', 'desc')->take(5)->get();
        $transactions_coming   = Transactions::where('status', 'pending')->orderBy('date_due', 'asc')->take(5)->get();
        $js                    = "$('#treeview-business').addClass('active');\n";
        return view('admin.dashboard')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('dashboard', $dashboard)->with('reservations_new', $reservations_new)->with('transactions_received', $transactions_received)->with('transactions_coming', $transactions_coming)->with('arrivals', $arrivals)->with('departures', $departures)->with('js', $js);
    }
    //Prepare the notifcations to show in the admin panel.
    public function notifications()
    {
        $bookings     = Reservations::where('is_seen', '0')->where('date_start', '>=', date('Y-m-d'))->orderBy('created_at', 'desc')->get();
        $arrivals = Reservations::whereBetween('date_start', [date('Y-m-d'),date('Y-m-d',strtotime("+1 month"))])
        ->orderBy('date_start', 'asc')
        ->get();
        $transactions = Transactions::where('date_paid', '<=', date('Y-m-d H:i:s'))->orderBy('date_paid', 'desc')->orderBy('date_due', 'desc')->get();
        return $array = (object) array(
            'bookings' => $bookings,
            'arrivals' => $arrivals,
            'transactions' => $transactions
        );
    }
    
}
