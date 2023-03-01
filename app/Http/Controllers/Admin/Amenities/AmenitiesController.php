<?php
namespace App\Http\Controllers\Admin\Amenities;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\AmenitiesFormRequest;
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
use App\Models\Amenities;

class AmenitiesController extends Controller
{
    //List of amenities
    public function index(Panel $panel)
    {
        $settings      = Settings::find(1);
        $user          = Auth::user();
        $notifications = $panel->notifications();
        $amenities     = Amenities::orderBy('display_order', 'asc')->get();
        $js            = "$('#treeview-properties').addClass('active');\n";
        return view('admin.amenities.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('amenities', $amenities)->with('js', $js);
    }
    //Add form
    public function create()
    {
        return view('admin.amenities.create');
    }
    //Inserts a new amenity
    public function store(AmenitiesFormRequest $request)
    {
        $amenity                = new Amenities();
        $amenity->title         = $request->input('title');
        $amenity->display_order = $request->input('display_order');
        if ($request->has('is_active')) {
            $amenity->is_active = 1;
        } //$request->has('is_active')
        else {
            $amenity->is_active = 0;
        }
        $amenity->save();
        $message = 'Successfully saved';
        return redirect('admin/amenities/edit/' . $amenity->id)->withMessage($message);
    }
    //Edit an amenity
    public function edit($id)
    {
        $amenity = Amenities::where('id', $id)->first();
        return view('admin.amenities.edit')->with('amenity', $amenity);
    }
    //Updates an item in the database table
    public function update(AmenitiesFormRequest $request)
    {
        $id                     = $request->input('id');
        $amenity                = Amenities::find($id);
        $amenity->title         = $request->input('title');
        $amenity->display_order = $request->input('display_order');
        if ($request->has('is_active')) {
            $amenity->is_active = 1;
        } //$request->has('is_active')
        else {
            $amenity->is_active = 0;
        }
        $amenity->save();
        $message = 'Successfully saved';
        return redirect('/admin/amenities/edit/' . $id)->withMessage($message);
    }
    //Deletes
    public function destroy(Request $request, $id)
    {
        $amenity = Amenities::find($id);
        $amenity->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/admin/amenities')->with($data);
    }
}
