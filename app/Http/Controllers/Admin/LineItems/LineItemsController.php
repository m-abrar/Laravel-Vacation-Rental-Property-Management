<?php
namespace App\Http\Controllers\Admin\LineItems;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\LineItemsFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;

use App\Models\Settings;
use App\Models\LineItems;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\ModelLocations;
use App\Models\PropertiesRates;
use App\Models\Calendar;
use Illuminate\Support\Facades\Auth;

class LineItemsController extends Controller
{
    //List of records
    public function index(Panel $panel)
    {
        $lineitems     = LineItems::orderBy('display_order', 'asc')->get();
        $settings      = Settings::find(1);
        $user          = Auth::user();
        $notifications = $panel->notifications();
        $js            = "$('#treeview-properties').addClass('active');\n";
        return view('admin.line-items.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('lineitems', $lineitems)->with('js', $js);
    }
    //Add form
    public function create()
    {
        return view('admin.line-items.create');
    }
    //Inserts
    public function store(LineItemsFormRequest $request)
    {
        $lineitem        = new LineItems();
        $lineitem->title = $request->get('title');
        $lineitem->save();
        $lineitem->slug = $slug = str_slug($lineitem->title . '_' . $lineitem->id, $separator = '_');
        $duplicate      = LineItems::where('slug', $slug)->first();
        if ($duplicate) {
            return redirect('/admin/line-items/create')->withErrors('Title or slug already exists.')->withInput();
        } //$duplicate
        $lineitem->value         = $request->get('value');
        $lineitem->description   = $request->get('description');
        $lineitem->value_type    = $request->get('value_type');
        $lineitem->apply_on      = $request->get('apply_on');
        $lineitem->display_order = $request->get('display_order');
        if ($request->has('is_required')) {
            $lineitem->is_required = 1;
        } //$request->has('is_required')
        else {
            $lineitem->is_required = 0;
        }
        if ($request->has('is_active')) {
            $lineitem->is_active = 1;
        } //$request->has('is_active')
        else {
            $lineitem->is_active = 0;
        }
        $lineitem->save();
        $message = 'Successfully saved';
        return redirect('admin/line-items/edit/' . $lineitem->id)->withMessage($message);
    }
    //Edit form
    public function edit($id)
    {
        $lineitem = LineItems::where('id', $id)->first();
        return view('admin.line-items.edit')->with('lineitem', $lineitem);
    }
    //Update the database
    public function update(LineItemsFormRequest $request)
    {
        $id              = $request->input('id');
        $lineitem        = LineItems::find($id);
        $lineitem->title = $request->get('title');
        $lineitem->slug  = $slug = str_slug($lineitem->title . '_' . $id, $separator = '_');
        $duplicate       = LineItems::where('slug', $slug)->where('id', '!=', $id)->first();
        if ($duplicate) {
            return redirect('/admin/line-items/edit/' . $id)->withErrors('Title or slug already exists.')->withInput();
        } //$duplicate
        $lineitem->value         = $request->get('value');
        $lineitem->description   = $request->get('description');
        $lineitem->value_type    = $request->get('value_type');
        $lineitem->apply_on      = $request->get('apply_on');
        $lineitem->display_order = $request->get('display_order');
        if ($request->has('is_required')) {
            $lineitem->is_required = 1;
        } //$request->has('is_required')
        else {
            $lineitem->is_required = 0;
        }
        if ($request->has('is_active')) {
            $lineitem->is_active = 1;
        } //$request->has('is_active')
        else {
            $lineitem->is_active = 0;
        }
        $message = 'Successfully saved';
        $lineitem->save();
        return redirect('/admin/line-items/edit/' . $id)->withMessage($message);
    }
    //Delete
    public function destroy(Request $request, $id)
    {
        $lineitem = LineItems::find($id);
        $lineitem->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/admin/line-items')->with($data);
    }
}
