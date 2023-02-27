<?php
namespace App\Http\Controllers\Admin\Reports;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SelectDatesController as Calendar;
use App\Http\Controllers\Admin\AdminController as Panel;
use App\Http\Requests\ReservationsFormRequest;
use Illuminate\Http\Request;
class ReportsController extends Controller
{
    //Generate reports for owner(s) between given dates
    public function owners(Request $request, Panel $panel, $date_start = '', $date_end = '', $owner_id = '')
    {
        if (@$request->input('search_dates')) {
            $search_dates = $request->input('search_dates');
            list($search_start, $search_end) = explode(' - ', $search_dates);
            $search_start = date('Y-m-d', strtotime($search_start));
            $search_end   = date('Y-m-d', strtotime($search_end));
            $owner_id     = $request->input('owner_id');
            return redirect('admin/reports/owners/' . $search_start . '/' . $search_end . '/' . $owner_id);
        } //@$request->input('search_dates')
        if (!empty($date_start) and !empty($date_end)) {
            $date_start   = date('Y-m-d', strtotime($date_start));
            $date_end     = date('Y-m-d', strtotime($date_end));
            $search_dates = date('m/d/Y', strtotime($date_start)) . ' - ' . date('m/d/Y', strtotime($date_end));
        } //!empty($date_start) and !empty($date_end)
        else {
            $date_start   = date('Y-m-d', strtotime('-1 month'));
            $date_end     = date('Y-m-d');
            $search_dates = date('m/d/Y', strtotime($date_start)) . ' - ' . date('m/d/Y', strtotime($date_end));
        }
        if ($owner_id != 0 and $owner_id !== null) {
            $owners = \App\Owners::where('id', $owner_id)->get();
        } //$owner_id != 0 and $owner_id !== null
        else {
            $owners = \App\Owners::orderBy('firstname', 'asc')->get();
        }
        $reports = array();
        foreach ($owners as $owner) {
            foreach ($owner->properties as $property) {
                foreach ($property->reservations as $reservation) {
                    if (strtotime($reservation->date_start) >= strtotime($date_start) && strtotime($reservation->date_start) <= strtotime($date_end)) {
                        $report = $reservation;
                        array_push($reports, $report);
                    } //strtotime($reservation->date_start) >= strtotime($date_start) && strtotime($reservation->date_start) <= strtotime($date_end)
                } //$property->reservations as $reservation
            } //$owner->properties as $property
        } //$owners as $owner
        $owners        = \App\Owners::orderBy('firstname', 'asc')->get();
        $settings      = \App\Settings::find(1);
        $user          = \Auth::user();
        $notifications = $panel->notifications();
        $js            = "$('#treeview-business').addClass('active');\n";
        $js .= "$('#treeview-reports').addClass('active');\n";
        return view('admin.reports.owners')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('owners', $owners)->with('owner_id', @$owner_id)->with('search_dates', $search_dates)->with('date_start', $date_start)->with('date_end', $date_end)->with('reports', $reports)->with('js', $js);
    }
    //Generates reports for housekeepers between given dates
    public function housekeepers(Request $request, Panel $panel, $date_start = '', $date_end = '', $housekeeper_id = '')
    {
        if (@$request->input('search_dates')) {
            $search_dates = $request->input('search_dates');
            list($search_start, $search_end) = explode(' - ', $search_dates);
            $search_start   = date('Y-m-d', strtotime($search_start));
            $search_end     = date('Y-m-d', strtotime($search_end));
            $housekeeper_id = $request->input('housekeeper_id');
            return redirect('admin/reports/housekeepers/' . $search_start . '/' . $search_end . '/' . $housekeeper_id);
        } //@$request->input('search_dates')
        if (!empty($date_start) and !empty($date_end)) {
            $date_start   = date('Y-m-d', strtotime($date_start));
            $date_end     = date('Y-m-d', strtotime($date_end));
            $search_dates = date('m/d/Y', strtotime($date_start)) . ' - ' . date('m/d/Y', strtotime($date_end));
        } //!empty($date_start) and !empty($date_end)
        else {
            $date_start   = date('Y-m-d', strtotime('-1 month'));
            $date_end     = date('Y-m-d');
            $search_dates = date('m/d/Y', strtotime($date_start)) . ' - ' . date('m/d/Y', strtotime($date_end));
        }
        if ($housekeeper_id != 0 and $housekeeper_id !== null) {
            $housekeepers = \App\Facilitators::where('role', 'housekeeper')->where('id', $housekeeper_id)->get();
        } //$housekeeper_id != 0 and $housekeeper_id !== null
        else {
            $housekeepers = \App\Facilitators::where('role', 'housekeeper')->orderBy('firstname', 'asc')->get();
        }
        $reports = array();
        foreach ($housekeepers as $housekeeper) {
            foreach ($housekeeper->housekeeperproperties as $property) {
                foreach ($property->reservations as $reservation) {
                    if (strtotime($reservation->date_start) >= strtotime($date_start) && strtotime($reservation->date_start) <= strtotime($date_end)) {
                        $report = $reservation;
                        array_push($reports, $report);
                    } //strtotime($reservation->date_start) >= strtotime($date_start) && strtotime($reservation->date_start) <= strtotime($date_end)
                } //$property->reservations as $reservation
            } //$housekeeper->housekeeperproperties as $property
        } //$housekeepers as $housekeeper
        $js = "$('#treeview-business').addClass('active');\n";
        $js .= "$('#treeview-reports').addClass('active');\n";
        $housekeepers  = \App\Facilitators::where('role', 'housekeeper')->orderBy('firstname', 'asc')->get();
        $settings      = \App\Settings::find(1);
        $user          = \Auth::user();
        $notifications = $panel->notifications();
        return view('admin.reports.housekeepers')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('housekeepers', $housekeepers)->with('housekeeper_id', @$housekeeper_id)->with('search_dates', $search_dates)->with('date_start', $date_start)->with('date_end', $date_end)->with('reports', $reports)->with('js', $js);
    }
    //Generates reports for vendors between given dates
    public function vendors(Request $request, Panel $panel, $date_start = '', $date_end = '', $vendor_id = '')
    {
        if (@$request->input('search_dates')) {
            $search_dates = $request->input('search_dates');
            list($search_start, $search_end) = explode(' - ', $search_dates);
            $search_start = date('Y-m-d', strtotime($search_start));
            $search_end   = date('Y-m-d', strtotime($search_end));
            $vendor_id    = $request->input('vendor_id');
            return redirect('admin/reports/vendors/' . $search_start . '/' . $search_end . '/' . $vendor_id);
        } //@$request->input('search_dates')
        if (!empty($date_start) and !empty($date_end)) {
            $date_start   = date('Y-m-d', strtotime($date_start));
            $date_end     = date('Y-m-d', strtotime($date_end));
            $search_dates = date('m/d/Y', strtotime($date_start)) . ' - ' . date('m/d/Y', strtotime($date_end));
        } //!empty($date_start) and !empty($date_end)
        else {
            $date_start   = date('Y-m-d', strtotime('-1 month'));
            $date_end     = date('Y-m-d');
            $search_dates = date('m/d/Y', strtotime($date_start)) . ' - ' . date('m/d/Y', strtotime($date_end));
        }
        if ($vendor_id != 0 and $vendor_id !== null) {
            $vendors = \App\Facilitators::where('role', 'vendor')->where('id', $vendor_id)->get();
        } //$vendor_id != 0 and $vendor_id !== null
        else {
            $vendors = \App\Facilitators::where('role', 'vendor')->orderBy('firstname', 'asc')->get();
        }
        $reports = array();
        foreach ($vendors as $vendor) {
            foreach ($vendor->vendorproperties as $property) {
                foreach ($property->reservations as $reservation) {
                    if (strtotime($reservation->date_start) >= strtotime($date_start) && strtotime($reservation->date_start) <= strtotime($date_end)) {
                        $report = $reservation;
                        array_push($reports, $report);
                    } //strtotime($reservation->date_start) >= strtotime($date_start) && strtotime($reservation->date_start) <= strtotime($date_end)
                } //$property->reservations as $reservation
            } //$vendor->vendorproperties as $property
        } //$vendors as $vendor
        $js = "$('#treeview-business').addClass('active');\n";
        $js .= "$('#treeview-reports').addClass('active');\n";
        $vendors       = \App\Facilitators::where('role', 'vendor')->orderBy('firstname', 'asc')->get();
        $settings      = \App\Settings::find(1);
        $user          = \Auth::user();
        $notifications = $panel->notifications();
        return view('admin.reports.vendors')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('vendors', $vendors)->with('vendor_id', @$vendor_id)->with('search_dates', $search_dates)->with('date_start', $date_start)->with('date_end', $date_end)->with('reports', $reports)->with('js', $js);
    }
}
