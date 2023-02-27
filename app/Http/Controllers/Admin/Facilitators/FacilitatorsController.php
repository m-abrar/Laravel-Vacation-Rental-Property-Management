<?php
namespace App\Http\Controllers\Admin\Facilitators;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\FacilitatorsFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;
class FacilitatorsController extends Controller
{
    //List of Housekeepers/Vendors with add/delete/update actions
    public function index(Panel $panel)
    {
        $settings                 = \App\Settings::find(1);
        $user                     = \Auth::user();
        $notifications            = $panel->notifications();
        $facilitators_housekeeper = \App\Facilitators::where('role', 'housekeeper')->orderBy('firstname', 'asc')->get();
        $facilitators_vendor      = \App\Facilitators::where('role', 'vendor')->orderBy('firstname', 'asc')->get();
        $js                       = "$('#treeview-people').addClass('active');\n";
        return view('admin.facilitators.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('facilitators_housekeeper', $facilitators_housekeeper)->with('facilitators_vendor', $facilitators_vendor)->with('js', $js);
    }
    //Add form
    public function create()
    {
        return view('admin.facilitators.create');
    }
    //Inserts into database table
    public function store(FacilitatorsFormRequest $request)
    {
        $facilitator                 = new \App\Facilitators();
        $facilitator->role           = $request->get('role');
        $facilitator->firstname      = $request->get('firstname');
        $facilitator->lastname       = $request->get('lastname');
        $facilitator->address_line_1 = $request->get('address_line_1');
        $facilitator->address_line_2 = $request->get('address_line_2');
        $facilitator->city           = $request->get('city');
        $facilitator->state          = $request->get('state');
        $facilitator->zip            = $request->get('zip');
        $facilitator->phone          = $request->get('phone');
        $facilitator->email          = $request->get('email');
        $facilitator->notes          = $request->get('notes');
        $facilitator->display_order  = $request->get('display_order')?$request->get('display_order'):0;
        if ($request->has('is_active')) {
            $facilitator->is_active = 1;
        } //$request->has('is_active')
        else {
            $facilitator->is_active = 0;
        }
        $facilitator->save();
        @$message .= 'Successfully saved.<br/>';
        $fileprefix = 'facilitator-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $facilitator->image = $filepath . $fileprefix . $filename;
            $facilitator->save();
            @$message .= 'Picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        return redirect('admin/facilitators/edit/' . $facilitator->id)->withMessage($message);
    }
    //Edit form
    public function edit($id)
    {
        $facilitator = \App\Facilitators::where('id', $id)->first();
        return view('admin.facilitators.edit')->with('facilitator', $facilitator);
    }
    //Update form
    public function update(FacilitatorsFormRequest $request)
    {
        $id                          = $request->input('id');
        $facilitator                 = \App\Facilitators::find($id);
        $facilitator->role           = $request->get('role');
        $facilitator->firstname      = $request->get('firstname');
        $facilitator->lastname       = $request->get('lastname');
        $facilitator->address_line_1 = $request->get('address_line_1');
        $facilitator->address_line_2 = $request->get('address_line_2');
        $facilitator->city           = $request->get('city');
        $facilitator->state          = $request->get('state');
        $facilitator->zip            = $request->get('zip');
        $facilitator->phone          = $request->get('phone');
        $facilitator->email          = $request->get('email');
        $facilitator->notes          = $request->get('notes');
        $facilitator->display_order  = $request->get('display_order')?$request->get('display_order'):0;
        if ($request->has('is_active')) {
            $facilitator->is_active = 1;
        } //$request->has('is_active')
        else {
            $facilitator->is_active = 0;
        }
        $facilitator->save();
        @$message .= 'Successfully saved.<br/>';
        $fileprefix = 'facilitator-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $facilitator->image = $filepath . $fileprefix . $filename;
            $facilitator->save();
            @$message .= 'Picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        return redirect('/admin/facilitators/edit/' . $id)->withMessage($message);
    }
    //Delete
    public function destroy(Request $request, $id)
    {
        $facilitator = \App\Facilitators::find($id);
        $facilitator->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/admin/facilitators')->with($data);
    }
}
