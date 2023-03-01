<?php
namespace App\Http\Controllers\Admin\Locations;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\LocationsFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;

use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\ModelLocations;
use App\Models\PropertiesRates;
use App\Models\Calendar;
use Illuminate\Support\Facades\Auth;


class LocationsController extends Controller
{
    public function getLocationID($slug){
        $location    = ModelLocations::where('slug', $slug)->first();
        return $location->id;
    }


    // List of locations, states, cities.
    public function index(Panel $panel)
    {
        $settings      = Settings::find(1);
        $user          = Auth::user();
        $notifications = $panel->notifications();
        $locations     = ModelLocations::orderBy('display_order', 'asc')->get();
        $js            = "$('#treeview-properties').addClass('active');\n";
        return view('admin.locations.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('locations', $locations)->with('js', $js);
    }
    //Add a new location item
    public function create()
    {
        $countries       = Locations::where('type', 'country')->orderBy('display_order', 'asc')->get();
        return view('admin.locations.create')->with('countries', $countries);
    }
    //Insert a new location item
    public function store(LocationsFormRequest $request)
    {
        $locations            = new Locations();
        $country = $request->input('country');
        if($country == 'new'){
            $locations->parent_id = 0;
            $locations->type = 'country';
        }else{
            $locations->parent_id = $country;
            $locations->type = 'state';
        }
        $locations->title     = $request->get('title');
        $locations->slug  = $slug = str_slug($request->input('slug')?$request->input('slug'):$locations->title);
        $duplicate       = Locations::where('slug', $slug)->first();
        if ($duplicate)
            return redirect('/admin/locations/create')->withErrors('Slug must not be already used!')->withInput();

        $locations->is_active = $request->has('is_active') ? 1 : 0;
        $locations->save();
        @$message .= 'Location added.<br/>';
        $fileprefix = 'location-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $locations->image = $filepath . $fileprefix . $filename;
            $locations->save();
            @$message .= 'Picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        return redirect('admin/locations/edit/' . $locations->id)->withMessage($message);
    }
    //Edit a location item
    public function edit($id)
    {
        $countries       = Locations::where('type', 'country')->orderBy('display_order', 'asc')->get();
        $location = Locations::where('id', $id)->first();
        return view('admin.locations.edit')->with('countries', $countries)->with('location', $location);
    }
    //Update the database table
    public function update(LocationsFormRequest $request)
    {
        $id               = $request->input('id');
        $locations        = Locations::find($id);
        $country = $request->input('country');
        if($country == 'new'){
            $locations->parent_id = 0;
            $locations->type = 'country';
        }else{
            $locations->parent_id = $country;
            $locations->type = 'state';
        }
        $locations->title = $request->input('title');
        $locations->slug  = $slug = str_slug($request->input('slug')?$request->input('slug'):$locations->title);

        $duplicate       = Locations::where('slug', $slug)->where('id', '!=', $id)->first();
        if ($duplicate){
            return redirect('/admin/locations/edit/' . $id)->withErrors('Slug must not be already used!')->withInput();
        }

        @$message .= 'Location updated.<br/>';
        $locations->is_active = $request->has('is_active') ? 1 : 0;
        $locations->save();
        $fileprefix = 'location-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $locations->image = $filepath . $fileprefix . $filename;
            $locations->save();
            @$message .= 'Picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        return redirect('/admin/locations/edit/' . $id)->withMessage($message);
    }
    //Deletes the item
    public function destroy(Request $request, $id)
    {
        $locations = Locations::find($id);
        $locations->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/admin/locations')->with($data);
    }
}
