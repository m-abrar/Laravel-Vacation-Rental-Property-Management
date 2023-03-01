<?php
namespace App\Http\Controllers\Admin\Features;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeaturesFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;

use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\ModelLocations;
use App\Models\PropertiesRates;
use App\Models\Features;
use Illuminate\Support\Facades\Auth;

class FeaturesController extends Controller
{
    //List of items
    public function index(Panel $panel)
    {
        $settings      = Settings::find(1);
        $user          = Auth::user();
        $notifications = $panel->notifications();
        $features      = Features::all();
        $js            = "$('#treeview-properties').addClass('active');\n";
        return view('admin.features.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('features', $features)->with('js', $js);
    }
    //Add form
    public function create()
    {
        return view('admin.features.create');
    }
    //Insert
    public function store(FeaturesFormRequest $request)
    {
        $feature                = new Features();
        $feature->title         = $request->get('title');
        $feature->display_order = $request->get('display_order');
        if ($request->has('is_active')) {
            $feature->is_active = 1;
        } //$request->has('is_active')
        else {
            $feature->is_active = 0;
        }
        $feature->save();
        $message = 'Successfully saved';
        return redirect('admin/features/edit/' . $feature->id)->withMessage($message);
    }
    //Edit form
    public function edit($id)
    {
        $feature = Features::where('id', $id)->first();
        return view('admin.features.edit')->with('feature', $feature);
    }
    //Save changes to the database
    public function update(FeaturesFormRequest $request)
    {
        $id                     = $request->input('id');
        $feature                = Features::find($id);
        $feature->title         = $request->input('title');
        $feature->display_order = $request->get('display_order');
        if ($request->has('is_active')) {
            $feature->is_active = 1;
        } //$request->has('is_active')
        else {
            $feature->is_active = 0;
        }
        $message = 'Successfully saved';
        $feature->save();
        return redirect('/admin/features/edit/' . $id)->withMessage($message);
    }
    //Delete
    public function destroy(Request $request, $id)
    {
        //future: delete the added ones
        $feature = Features::find($id);
        $feature->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/admin/features')->with($data);
    }
}
