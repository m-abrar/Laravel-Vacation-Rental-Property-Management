<?php
namespace App\Http\Controllers\Admin\Seasons;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeasonsFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
// use Auth;

use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\ModelLocations;
use App\Models\PropertiesRates;
use App\Models\Seasons;

class SeasonsController extends Controller
{
    //List of seasons with add/edit/delete actions
    public function index(Panel $panel)
    {
        $settings      = Settings::find(1);
        $user          = Auth::user();
        $notifications = $panel->notifications();
        $season        = Seasons::orderBy('display_order', 'asc')->get();
        $js            = "$('#treeview-properties').addClass('active');\n";
        return view('admin.seasons.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('seasons', $season)->with('js', $js);
    }
    //Form for adding
    public function create()
    {
        return view('admin.seasons.create');
    }
    //Inserts into database
    public function store(SeasonsFormRequest $request)
    {
        $season                     = new Seasons();
        $season->title              = $request->get('title');
        $season->season_start_month = $request->get('season_start_month');
        $season->season_start_day   = $request->get('season_start_day');
        $season->season_end_month   = $request->get('season_end_month');
        $season->season_end_day     = $request->get('season_end_day');
        $season->description        = $request->get('description');
        $season->display_order      = $request->get('display_order');
        $season->is_active = $request->has('is_active')?1:0;
        $season->save();
        $message = 'Successfully saved';
        return redirect('admin/seasons/edit/' . $season->id)->withMessage($message);
    }
    //Edit form
    public function edit($id)
    {
        $season = Seasons::where('id', $id)->first();
        return view('admin.seasons.edit')->with('season', $season);
    }
    //Update the database table
    public function update(SeasonsFormRequest $request)
    {
        //
        $id                         = $request->input('id');
        $season                     = Seasons::find($id);
        $season->title              = $request->get('title');
        $season->season_start_month = $request->get('season_start_month');
        $season->season_start_day   = $request->get('season_start_day');
        $season->season_end_month   = $request->get('season_end_month');
        $season->season_end_day     = $request->get('season_end_day');
        $season->description        = $request->get('description');
        $season->display_order      = $request->get('display_order');
        $season->is_active = $request->has('is_active')?1:0;
        $season->save();
        $message = 'Successfully saved';
        return redirect('/admin/seasons/edit/' . $id)->withMessage($message);
    }
    //Delete
    public function destroy(Request $request, $id)
    {
        $season = Seasons::find($id);
        $season->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/admin/seasons')->with($data);
    }
}
