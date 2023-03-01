<?php
namespace App\Http\Controllers\Admin\Sliders;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\SlidersFormRequest;
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
use App\Models\Calendar;

class SlidersController extends Controller
{
    // List of sliders
    public function index(Panel $panel)
    {
        $settings      = Settings::find(1);
        $user          = Auth::user();
        $notifications = $panel->notifications();
        $sliders       = Sliders::orderBy('display_order', 'asc')->get();
        $js            = "$('#treeview-website').addClass('active');\n";
        return view('admin.sliders.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('sliders', $sliders)->with('js', $js);
    }
    //Add form
    public function create()
    {
        return view('admin.sliders.create');
    }
    //Inserts
    public function store(SlidersFormRequest $request)
    {
        $slider            = new Sliders();
        $slider->title     = $request->get('title');
        $slider->is_active = $request->has('is_active') ? 1 : 0;
        $slider->save();
        @$message .= 'Slider added.<br/>';
        $fileprefix = 'slider-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $slider->image = $filepath . $fileprefix . $filename;
            $slider->save();
            @$message .= 'Picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        return redirect('admin/sliders/edit/' . $slider->id)->withMessage($message);
    }
    //Edit form
    public function edit($id)
    {
        $slider = Sliders::where('id', $id)->first();
        return view('admin.sliders.edit')->with('slider', $slider);
    }
    //Update the database
    public function update(SlidersFormRequest $request)
    {
        
        //
        $id            = $request->input('id');
        $slider        = Sliders::find($id);
        $slider->title = $request->input('title');
        $slider->is_active = $request->has('is_active') ? 1 : 0;
        $slider->save();
        @$message .= 'Slider updated.<br/>';
        
        $fileprefix = 'slider-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $slider->image = $filepath . $fileprefix . $filename;
            $slider->save();
            @$message .= 'Picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        
        //return redirect('/admin/sliders/edit/' . $id)->withMessage($message);
    }
    //Deletes a slider
    public function destroy(Request $request, $id)
    {
        $slider = Sliders::find($id);
        $slider->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/admin/sliders')->with($data);
    }
}
