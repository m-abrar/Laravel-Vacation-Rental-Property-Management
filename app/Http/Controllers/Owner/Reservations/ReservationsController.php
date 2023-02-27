<?php
namespace App\Http\Controllers\Owner\Reservations;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SelectDatesController as SelectDates;
use App\Http\Controllers\Owner\OwnerController as Panel;
use App\Http\Controllers\SendEmailsController as SendEmails;
use App\Http\Requests\ReservationsFormRequest;
use Illuminate\Http\Request;
class ReservationsController extends Controller
{
    //List of Reservations/Guests with actions to update/delete/add-new
    public function index(Panel $panel)
    {
        $settings             = Settings::find(1);
        $user                 = \Auth::user();
        $notifications        = $panel->notifications();
        $reservations_all     = Reservations::all();

        $properties    = Properties::select('id')->where('user_id', \Auth::user()->id)->get()->toArray();
        

        $reservations_all     = Reservations::whereIn('property_id', $properties)->get();


        $reservations_new     = Reservations::whereIn('property_id', $properties)->where('date_start', '>=', date('Y-m-d'))->where('is_seen', '0')->get();
        $reservations_current = Reservations::whereIn('property_id', $properties)->where('date_start', '>=', date('Y-m-d'))->get();
        $reservations_history = Reservations::whereIn('property_id', $properties)->where('date_end', '<=', date('Y-m-d'))->get();
        $js                   = "$('#treeview-business').addClass('active');\n";
        return view('owner.reservations.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('reservations_all', $reservations_all)->with('reservations_new', $reservations_new)->with('reservations_current', $reservations_current)->with('reservations_history', $reservations_history)->with('js', $js);
    }
    //Quick view of reservations in a calendar mode with add/edit actions.
    public function calendarView($year = '', $month = '')
    {
        $month                 = !empty($month) ? $month : date('n');
        $year                  = !empty($year) ? $year : date('Y');
        $timestamp             = mktime(0, 0, 0, $month, 1, $year);
        $monthtotaldays        = date('t', $timestamp);
        $thismonth             = getdate($timestamp);
        $startday              = $thismonth['wday'];
        $last_day_this_month   = date('Y-m-d', strtotime("$year-$month-$monthtotaldays"));
        $first_day_this_month  = date('Y-m-d', strtotime("$year-$month-1"));
        $calendarPreviousYear  = date('Y', strtotime("-1 month", strtotime($year . "-" . $month . "-01")));
        $calendarPreviousMonth = date('n', strtotime("-1 month", strtotime($year . "-" . $month . "-01")));
        $calendarNextYear      = date('Y', strtotime("+1 month", strtotime($year . "-" . $month . "-01")));
        $calendarNextMonth     = date('n', strtotime("+1 month", strtotime($year . "-" . $month . "-01")));
        $properties            = Properties::all();
        $dates_reserved        = '';
        foreach ($properties as $property) {
            $datesResult = \DB::table('emt_calendar as C')->leftJoin('emt_reservations as R', 'R.id', '=', 'C.reservation_id')->whereRaw("MONTH(C.date)='$month' AND YEAR(C.date)='$year'")->where('C.property_id', $property->id)->orderBy('C.date', 'asc')->select('C.date as date', 'C.status as status', 'C.reservation_id as reservation_id', 'R.firstname as firstname', 'R.lastname as lastname')->get();
            foreach ($datesResult as $date) {
                $reservationResult                                                            = Calendar::where('reservation_id', $date->reservation_id)->whereRaw("MONTH(date)='$month' AND YEAR(date)='$year'")->get();
                $reservation_total_days                                                       = count($reservationResult);
                $dates_reserved[$property->id]['date_' . date('Ymd', strtotime($date->date))] = array(
                    'status' => $date->status,
                    'reservation_id' => $date->reservation_id,
                    'firstname' => $date->firstname,
                    'lastname' => $date->lastname,
                    'reservation_total_days' => $reservation_total_days
                );
            } //$datesResult as $date
        } //$properties as $property
        $settings = Settings::find(1);
        return view('owner.reservations.calendar-view')->with('properties', $properties)->with('settings', $settings)->with('timestamp', $timestamp)->with('monthtotaldays', $monthtotaldays)->with('last_day_this_month', $last_day_this_month)->with('first_day_this_month', $first_day_this_month)->with('thismonth', $thismonth)->with('startday', $startday)->with('year', $year)->with('month', $month)->with('calendarPreviousYear', $calendarPreviousYear)->with('calendarPreviousMonth', $calendarPreviousMonth)->with('calendarNextYear', $calendarNextYear)->with('calendarNextMonth', $calendarNextMonth)->with('dates_reserved', $dates_reserved);
    }
    //Search available properties for going for a new booking.
    public function search(Request $request, Panel $panel, $date_start = '', $date_end = '')
    {
        if (@$request->input('search_dates')) {
            $search_dates = $request->input('search_dates');
            list($search_start, $search_end) = explode(' - ', $search_dates);
            $search_start = date('Y-m-d', strtotime($search_start));
            $search_end   = date('Y-m-d', strtotime($search_end));
            return redirect('owner/reservations/search/' . $search_start . '/' . $search_end);
        } //@$request->input('search_dates')
        $settings      = Settings::find(1);
        $user          = \Auth::user();
        $notifications = $panel->notifications();
        if (!empty($date_start) and !empty($date_end)) {
            $date_start   = date('Y-m-d', strtotime($date_start));
            $date_end     = date('Y-m-d', strtotime($date_end));
            $search_dates = date('m/d/Y', strtotime($date_start)) . ' - ' . date('m/d/Y', strtotime($date_end));
            $properties_vacation = Properties::where('is_active', 1)->where('is_vacation', 1)->with(array(
                'calendar' => function($query) use ($date_start, $date_end)
                {
                    $query->whereBetween('date',[$date_start,$date_end])->get();
                }
            ))->get();
            $properties          = array();
            foreach ($properties_vacation as $property) {
                if (count($property->calendar) == 0) {
                    //Available - Property has no calendar dates
                    array_push($properties, $property);
                } //count($property->calendar) == 0
            } //$properties_vacation as $property
        } //!empty($date_start) and !empty($date_end)
        else {
            $properties = Properties::where('is_active', 1)->where('is_vacation', 1)->get();
        }
        $js = "$('#treeview-business').addClass('active');\n";
        return view('owner.reservations.search')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('search_dates', @$search_dates)->with('date_start', @$date_start)->with('date_end', @$date_end)->with('properties', $properties)->with('js', $js);
    }
    //Form for creating a new reservation
    public function create($property = '', $pre_select_date_start = 'NA', $pre_select_date_end = 'NA')
    {
        $propertyResult = Properties::where('slug', $property)->first();
        $property_id    = $propertyResult->id;
        $reservation_id = time();
        $states         = Locations::where('type', 'state')->where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $addons         = Services::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $lineitems      = LineItems::where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $housekeepers   = Facilitators::where('role', 'housekeeper')->where('is_active', '1')->orderBy('firstname', 'asc')->get();
        $vendors        = Facilitators::where('role', 'vendor')->where('is_active', '1')->orderBy('firstname', 'asc')->get();
        return view('owner.reservations.create')->with('reservation_id', $reservation_id)
        ->with('property_id', $property_id)
        ->with('pre_select_date_start', $pre_select_date_start)->with('pre_select_date_end', $pre_select_date_end)
        ->with('property_slug', $property)->with('states', $states)
        ->with('addons', $addons)->with('lineitems', $lineitems)
        ->with('housekeepers', $housekeepers)->with('vendors', $vendors);
    }
    //Insert a new reservation into database.
    public function store(SelectDates $select_dates, ReservationsFormRequest $request, SendEmails $sendemails, $slug)
    {
        if ($request->input('dates_searched') == null) {
            return redirect('owner/reservations/create/' . $slug)->withErrors('You must select avaialable dates on the calendar.<br/>')->withInput();
        } //$request->input('dates_searched') == null
        $dates_searched = explode(',',$request->input('dates_searched'));

        $date_start = min($dates_searched);
        $date_end = max($dates_searched);
        $property        = Properties::where('slug', $slug)->first();
        $property_id           = $property->id;

        $availability = $select_dates->isPropertyAvailable($property_id,$date_start,$date_end);
        if (true !== $availability){
            return redirect("owner/reservations/create/$slug/$date_start/$date_end")
                                    ->withErrors('Sorry, property is not available.<br/>'.$availability)
                                    ->withInput();
        }

        $lodging_amount = $select_dates->calculateLodgingPrice($slug,$date_start,$date_end);
         if (!is_numeric($lodging_amount)){
                @$error .= $lodging_amount;
                die('Lodging Amount Error');//abrar redirect the error to frontend
            }


        $reservation                   = new Reservations();
        $reservation->uniqid           = uniqid();

        $reservation->property_id      = $property_id;

        list($success, $error, $id) = ReservationsController::save($request, $select_dates, $sendemails, $reservation, $date_start, $date_end);
        return redirect('owner/reservations/edit/' . $reservation->id)->withErrors(@$error)->withMessage(@$success);
    }
    //Show a reservation and payments relavant to it.
    public function show(Panel $panel, $id)
    {
        $settings              = Settings::find(1);
        $user                  = \Auth::user();
        $notifications         = $panel->notifications();
        $reservation           = Reservations::where('id', $id)->first();
        $pre_select_date_start = $reservation->date_start;
        $pre_select_date_end   = $reservation->date_end;
        $propertyResult        = Properties::where('id', $reservation->property_id)->first();
        $property_id           = $propertyResult->id;
        $property_slug         = $propertyResult->slug;
        $reservation_id        = $id;
        $states                = Locations::where('type', 'state')->where('is_active', '1')->get();
        $addons                = Services::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $lineitems             = LineItems::where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $lineitems_final       = array();
        foreach ($lineitems as $lineitem) {
            $selected = \DB::table('emt_reservations_line_items')->where('line_item_id', $lineitem->id)->where('reservation_id', $reservation->id)->get();
            $selected = (count($selected)) ? true : false;
            $array    = (object) array(
                'id' => $lineitem->id,
                'title' => $lineitem->title,
                'value' => $lineitem->value,
                'description' => $lineitem->description,
                'slug' => $lineitem->slug,
                'value_type' => $lineitem->value_type,
                'is_required' => $lineitem->is_required,
                'apply_on' => $lineitem->apply_on,
                'image' => $lineitem->image,
                'is_active' => $lineitem->is_active,
                'display_order' => $lineitem->display_order,
                'selected' => $selected
            );
            array_push($lineitems_final, $array);
        } //$lineitems as $lineitem
        $housekeepers = Facilitators::where('role', 'housekeeper')->where('is_active', '1')->get();
        $vendors      = Facilitators::where('role', 'vendor')->where('is_active', '1')->get();
        return view('owner.reservations.show')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)
        ->with('reservation', $reservation)->with('reservation_id', $reservation_id)
        ->with('property_id', $property_id)->with('property_slug', $property_slug)
        ->with('pre_select_date_start', $pre_select_date_start)->with('pre_select_date_end', $pre_select_date_end)
        ->with('states', $states)->with('addons', $addons)->with('lineitems', $lineitems_final)
        ->with('housekeepers', $housekeepers)->with('vendors', $vendors);
    }
    //Make changes to a reservation
    public function edit($id)
    {
        $reservation           = Reservations::where('id', $id)->first();
        $pre_select_date_start = $reservation->date_start;
        $pre_select_date_end   = $reservation->date_end;
        $propertyResult        = Properties::where('id', $reservation->property_id)->first();
        $property_id           = $propertyResult->id;
        $property_slug         = $propertyResult->slug;
        $reservation_id        = $id;
        $states                = Locations::where('type', 'state')->where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $addons                = Services::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $lineitems             = LineItems::where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $lineitems_final       = array();
        foreach ($lineitems as $lineitem) {
            $selected = \DB::table('emt_reservations_line_items')->where('line_item_id', $lineitem->id)->where('reservation_id', $reservation->id)->get();
            $selected = (count($selected)) ? true : false;
            $array    = (object) array(
                'id' => $lineitem->id,
                'title' => $lineitem->title,
                'value' => $lineitem->value,
                'description' => $lineitem->description,
                'slug' => $lineitem->slug,
                'value_type' => $lineitem->value_type,
                'is_required' => $lineitem->is_required,
                'apply_on' => $lineitem->apply_on,
                'image' => $lineitem->image,
                'is_active' => $lineitem->is_active,
                'display_order' => $lineitem->display_order,
                'selected' => $selected
            );
            array_push($lineitems_final, $array);
        } //$lineitems as $lineitem
        $calendar       = Calendar::where('reservation_id', $id)->orderBy('date', 'asc')->get();
        $dates_searched = array();
        foreach ($calendar as $date) {
            array_push($dates_searched, $date->date);
        }
        $dates_searched = implode(',', $dates_searched);

        $housekeepers   = Facilitators::where('role', 'housekeeper')->where('is_active', '1')->orderBy('firstname', 'asc')->get();
        $vendors        = Facilitators::where('role', 'vendor')->where('is_active', '1')->orderBy('firstname', 'asc')->get();
        return view('owner.reservations.edit')
        ->with('reservation', $reservation)->with('edit', true)
        ->with('reservation_id', $reservation_id)->with('property_id', $property_id)
        ->with('property_slug', $property_slug)->with('pre_select_date_start', $pre_select_date_start)
        ->with('pre_select_date_end', $pre_select_date_end)->with('states', $states)
        ->with('dates_searched', $dates_searched)->with('addons', $addons)->with('lineitems', $lineitems_final)
        ->with('housekeepers', $housekeepers)->with('vendors', $vendors);
    }
    //Mute the notifications in the admin panel
    public function approve(Request $request)
    {
        $reservation          = Reservations::where('id', $request->get('id'))->first();
        $reservation->is_seen = $reservation->is_seen + 1;
        //$reservation->save();
        foreach ($reservation->transactions as $transaction) {
            $transaction->is_seen = $transaction->is_seen + 1;
            $transaction->save();
        } //$reservation->transactions as $transaction
        @$success .= 'Marked okayed.<br/>';
        return redirect('owner/reservations')->withMessage($success);
    }
    //Save the reservation changes in the form to the table.
    public function update(SelectDates $select_dates, ReservationsFormRequest $request, SendEmails $sendemails)
    {
        $id             = $request->input('id');
        $reservation    = Reservations::find($id);
        
        if ($request->input('dates_searched') == null) {
            return redirect('owner/reservations/edit/' . $id)->withErrors('You must select avaialable dates on the calendar.<br/>')->withInput();
        } //$request->input('dates_searched') == null

        $property_id = $reservation->property->id;
        $slug = $reservation->property->slug;
        
        $dates_searched = explode(',', $request->input('dates_searched'));
        $date_start     = min($dates_searched);
        $date_end       = max($dates_searched);
        $availability   = $select_dates->isPropertyAvailable($property_id, $date_start, $date_end, $id);
        if (true !== $availability) {
            return redirect('owner/reservations/edit/' . $id)->withErrors('Sorry, property is not available.<br/>' . $availability)->withInput();
        } //true !== $availability
        $lodging_amount = $select_dates->calculateLodgingPrice($slug, $date_start, $date_end, $id);
        if (!is_numeric($lodging_amount)) {
            @$error .= $lodging_amount;
            die('Lodging Amount Error'); //abrar redirect the error to frontend
        } //!is_numeric($lodging_amount)

        list($success, $error, $id) = ReservationsController::save($request, $select_dates, $sendemails, $reservation, $date_start, $date_end);
        return redirect('owner/reservations/edit/' . $reservation->id)->withErrors(@$error)->withMessage(@$success);
        
    }
    //Common part of code for insert and update.
    public function save($request, $select_dates, $sendemails, $reservation, $date_start, $date_end)
    {

        $reservation->firstname        = $request->get('firstname');
        $reservation->lastname         = $request->get('lastname');
        $reservation->address_line_1   = $request->get('address_line_1');
        $reservation->address_line_2   = $request->get('address_line_2');
        $reservation->city             = $request->get('city');
        $reservation->state_id         = $request->get('state');
        $reservation->zip              = $request->get('zip');
        $reservation->phone            = $request->get('phone');
        $reservation->email            = $request->get('email');
        $reservation->adults           = $request->get('adults');
        $reservation->children         = $request->get('children');
        $reservation->pets             = $request->get('pets');
        $reservation->date_start       = $date_start;
        $reservation->date_end         = date('Y-m-d',strtotime('+1 day',strtotime($date_end)));
        $reservation->lodging_amount   = $request->get('lodging_amount');
        $reservation->sub_total_detail = $request->get('sub_total_detail');
        $reservation->total_amount     = $request->get('total_amount');
        $reservation->status           = $request->get('booking_status');
        $reservation->created_by       = 'admin';
        $reservation->housekeeper_id   = $request->get('housekeeper_id');
        $reservation->vendor_id        = $request->get('vendor_id');
        $reservation->notes            = $request->get('notes');
        $reservation->save();
        @$success .= 'Reservation successfully saved.<br/>';
        $reservation_id = $reservation->id;
        if (!empty($reservation_id)) {
            
            $addons     = Services::where('is_active', '1')->orderBy('display_order', 'asc')->get();
            $addons_total = 0;
            foreach ($addons as $addon) {

                    $service                 = new ReservationsServices();
                    $service->reservation_id = $reservation_id;
                    $service->service_id     = $addon->id;
                    $service->quantity       = $request->get('quantity_'.$addon->id);
                    $service->price          = $addon->price * $service->quantity;
                    $service->save();
                    $addons_total += $service->price;

                }


            $lineitem     = LineItems::where('is_active', '1')->orderBy('display_order', 'asc')->get();
            $total_amount = $lodging_amount = $reservation->lodging_amount;
            foreach ($lineitem as $lineitem) {
                $line_item_id   = $lineitem->id;
                $line_item_name = $lineitem->title;
                if ($lineitem->is_required == '1') {
                    if ($lineitem->value_type == 'fixed' or $request->has('lineitem-' . $lineitem->id)) {
                        $value = $lineitem->value;
                    } //$lineitem->value_type == 'fixed'
                    if ($lineitem->value_type == 'percentage') {
                        $value = $lineitem->value;
                        if($lineitem->apply_on == "base"){
                            $value = ($lodging_amount * $value / 100);
                        }else{
                            $value = ($total_amount * $value / 100);
                        }
                    } //$lineitem->value_type == 'percentage'
                } //$lineitem->is_required == '1'
                
                if (isset($value)) {
                    $lineitem                 = new ReservationLineItems();
                    $lineitem->reservation_id = $reservation_id;
                    $lineitem->line_item_id   = $line_item_id;
                    $lineitem->value          = $value;
                    $lineitem->save();
                    $total_amount += $value;
                } //isset($value)
                unset($value);
            } //$lineitem as $lineitem
            $reservation->total_amount = $total_amount;
            $reservation->save();
            $date_start_loop = $date_start;
            $date_end_loop = $date_end;
            $loop_counter = 0;
            while ($date_start_loop <= $date_end_loop) {
                $calendar                 = new Calendar();
                $calendar->property_id    = $reservation->property_id;
                $calendar->reservation_id = $reservation_id;
                $calendar->date           = $date_start_loop;
                $calendar->status         = $reservation->status;
                $calendar->save();
                @$success .= "Booked: " . date("m/d/Y", strtotime($date_start_loop)) . "<br/>";
                $date_start_loop = date("Y-m-d", strtotime("+1 day", strtotime($date_start_loop)));
            $loop_counter++;
            if($loop_counter>999) break;
            } //$date_start_loop < $date_end_loop
        } //!empty($reservation_id)
        $final_payment_date = $select_dates->calculateFinalPaymentDate($reservation->property_id, $date_start, $date_end);
        if ($final_payment_date > date('Y-m-d')) {
            $deposit_term = 'half';
            $amount       = ($total_amount / 2);
        } //$final_payment_date > date('Y-m-d')
        else {
            $deposit_term = 'full';
            $amount       = $total_amount;
        }
        $payment_status              = 'pending';
        $transaction                 = new Transactions();
        $transaction->reservation_id = $reservation_id;
        $transaction->amount         = $amount;
        $transaction->deposit_term   = $deposit_term;
        $transaction->date_due       = date('Y-m-d');
        $transaction->status         = $payment_status;
        $transaction->save();
        if ($deposit_term == "half") {
            $transaction                 = new Transactions();
            $transaction->reservation_id = $reservation_id;
            $transaction->amount         = $amount;
            $transaction->deposit_term   = $deposit_term;
            $transaction->date_due       = $final_payment_date;
            $transaction->status         = $payment_status;
            $transaction->save();
        } //$deposit_term == "half"
        if ($request->has('notify_customer')) {
            $sent = $sendemails->reservationSuccess($reservation->id); //$reservation->id
            $sent === true ? @$success .= 'Email sent to Customer.<br/>' : @$error .= 'No email sent to Customer.<br/>';
        } //$request->has('notify_customer')
        if ($request->has('notify_owner')) {
            $sent = $sendemails->notifyOwner($reservation->id); //$reservation->id
            $sent === true ? @$success .= 'Email sent to Owner<br/>' : @$error .= 'No email sent to Owner<br/>';
        } //$request->has('notify_owner')
        if ($request->has('notify_housekeeper')) {
            $sent = $sendemails->notifyHousekeeper($reservation->id); //$reservation->id
            $sent === true ? @$success .= 'Email sent to Housekeeper<br/>' : @$error .= 'No email sent to Housekeeper<br/>';
        } //$request->has('notify_housekeeper')
        if ($request->has('notify_vendor')) {
            $sent = $sendemails->notifyVendor($reservation->id); //$reservation->id
            $sent === true ? @$success .= 'Email sent to Vendor<br/>' : @$error .= 'No email sent to Vendor<br/>';
        } //$request->has('notify_vendor')
        return array(
            @$success,
            @$error,
            $reservation_id
        );
    }
    //Delete reservation and its entries on the calendar.
    public function destroy(Request $request, $id)
    {
        $dates = Calendar::where('reservation_id', $id);
        $dates->delete();
        $lineitems = ReservationLineItems::where('reservation_id', $id);
        $lineitems->delete();
        $reservation = Reservations::find($id);
        $reservation->transactions()->delete();
        $reservation->delete();
        $success = 'Successfully deleted';
        return redirect('/owner/reservations')->withMessage($success);
    }
}
