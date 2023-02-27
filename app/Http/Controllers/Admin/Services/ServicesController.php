<?php
namespace App\Http\Controllers\Admin\Services;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServicesFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;
class ServicesController extends Controller
{
    //List of addon/services with actions to edit/delete
    public function index(Panel $panel)
    {
        $settings      = \App\Settings::find(1);
        $user          = \Auth::user();
        $notifications = $panel->notifications();
        $services = \App\Services::orderBy('display_order', 'asc')->get();
        $js            = "$('#treeview-properties').addClass('active');\n";
        return view('admin.services.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('services', $services)->with('js', $js);
    }
    //Form for adding a new addon/service to the system
    public function create()
    {
        return view('admin.services.create');
    }
    //Inserts a new record into database
    public function store(ServicesFormRequest $request)
    {
        $service            = new \App\Services();
        $service->title     = $request->get('title');
        $service->summary     = $request->get('summary');
        $service->description     = $request->get('description');
        $service->price     = $request->get('price');
        $service->display_order     = $request->get('display_order');
        $service->is_active = $request->has('is_active') ? 1 : 0;
        $service->save();
        @$message .= 'Service added.<br/>';
        $fileprefix = 'service-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $service->image = $filepath . $fileprefix . $filename;
            $service->save();
            @$message .= 'Picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        return redirect('admin/services/edit/' . $service->id)->withMessage($message);
    }
    //Edit form for a specific database row
    public function edit($id)
    {
        $service = \App\Services::where('id', $id)->first();
        return view('admin.services.edit')->with('service', $service);
    }
    //Update the specified row of the services table.
    public function update(ServicesFormRequest $request)
    {
        $id                   = $request->input('id');
        $service        = \App\Services::find($id);
        $service->title = $request->input('title');
        $service->summary     = $request->get('summary');
        $service->description     = $request->get('description');
        $service->price     = $request->get('price');
        $service->display_order     = $request->get('display_order');
        $service->is_active = $request->has('is_active') ? 1 : 0;
        $service->save();
        @$message .= 'Service updated.<br/>';
        $fileprefix = 'service-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $service->image = $filepath . $fileprefix . $filename;
            $service->save();
            @$message .= 'Picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        return redirect('/admin/services/edit/' . $id)->withMessage($message);
    }
    //Delete a row

    public function destroy(Request $request, $id)
    {
        $service = \App\Services::find($id);
        $service->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/admin/services')->with($data);
    }
}
