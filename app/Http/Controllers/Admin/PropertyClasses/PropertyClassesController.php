<?php
namespace App\Http\Controllers\Admin\PropertyClasses;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyClassesFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;
class PropertyClassesController extends Controller
{
    //List of classes of properties with actions to edit/delete
    public function index(Panel $panel)
    {
        $settings      = \App\Settings::find(1);
        $user          = \Auth::user();
        $notifications = $panel->notifications();
        $propertyclasses = \App\PropertyClasses::orderBy('display_order', 'asc')->get();
        $js            = "$('#treeview-properties').addClass('active');\n";
        return view('admin.property-classes.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('propertyclasses', $propertyclasses)->with('js', $js);
    }
    //Form for adding a new category of properties to the system
    public function create()
    {
        return view('admin.property-classes.create');
    }
    //Inserts a new record into database
    public function store(PropertyClassesFormRequest $request)
    {
        $propertyclasses            = new \App\PropertyClasses();
        $propertyclasses->title     = $request->get('title');
        $propertyclasses->is_active = $request->has('is_active') ? 1 : 0;
        $propertyclasses->save();
        @$message .= 'Property type added.<br/>';
        $fileprefix = 'property-type-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $propertyclasses->image = $filepath . $fileprefix . $filename;
            $propertyclasses->save();
            @$message .= 'Picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        return redirect('admin/property-classes/edit/' . $propertyclasses->id)->withMessage($message);
    }
    //Edit form for a specific database row
    public function edit($id)
    {
        $propertyclass = \App\PropertyClasses::where('id', $id)->first();
        return view('admin.property-classes.edit')->with('propertyclass', $propertyclass);
    }
    //Update the specified row of the property classes table.
    public function update(PropertyClassesFormRequest $request)
    {
        $id                   = $request->input('id');
        $propertyclasses        = \App\PropertyClasses::find($id);
        $propertyclasses->title = $request->input('title');
        @$message .= 'Property type updated.<br/>';
        $propertyclasses->is_active = $request->has('is_active') ? 1 : 0;
        $propertyclasses->save();
        $fileprefix = 'property-type-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $propertyclasses->image = $filepath . $fileprefix . $filename;
            $propertyclasses->save();
            @$message .= 'Picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        return redirect('/admin/property-classes/edit/' . $id)->withMessage($message);
    }
    //Delete a row
    //Properties that belong to this category will still remain on the database.
    public function destroy(Request $request, $id)
    {
        $propertyclasses = \App\PropertyClasses::find($id);
        $propertyclasses->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/admin/property-classes')->with($data);
    }
}
