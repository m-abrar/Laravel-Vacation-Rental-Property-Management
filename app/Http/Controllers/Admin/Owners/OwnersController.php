<?php
namespace App\Http\Controllers\Admin\Owners;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\OwnersFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;
class OwnersController extends Controller
{
    //List of entries in the table
    public function index(Panel $panel)
    {
        $settings      = \App\Settings::find(1);
        $user          = \Auth::user();
        $notifications = $panel->notifications();
        $owners        = \App\Owners::where('role', 'owner')->get();
        $js            = "$('#treeview-people').addClass('active');\n";
        return view('admin.owners.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('owners', $owners)->with('js', $js);
    }
    //Add form
    public function create()
    {
        return view('admin.owners.create');
    }
    //Insert
    public function store(OwnersFormRequest $request)
    {
        $owner                 = new \App\Owners();
        $owner->firstname      = $request->get('firstname');
        $owner->lastname       = $request->get('lastname');
        $owner->address_line_1 = $request->get('address_line_1');
        $owner->address_line_2 = $request->get('address_line_2');
        $owner->city           = $request->get('city');
        $owner->state          = $request->get('state');
        $owner->zip            = $request->get('zip');
        $owner->phone          = $request->get('phone');
        $owner->email          = $request->get('email');
        $owner->password       = \Hash::make( $request->get('password') );
        $owner->notes          = $request->get('notes');
        $owner->display_order  = $request->get('display_order')?$request->get('display_order'):0;
        if ($request->has('is_active')) {
            $owner->is_active = 1;
        } //$request->has('is_active')
        else {
            $owner->is_active = 0;
        }
        $owner->save();
        @$message .= 'Successfully saved.<br/>';
        $fileprefix = 'owner-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $owner->avatar = $filepath . $fileprefix . $filename;
            $owner->save();
            @$message .= 'Picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        return redirect('admin/owners/edit/' . $owner->id)->withMessage($message);
    }
    //Edit form
    public function edit($id)
    {
        $owner = \App\Owners::where('id', $id)->first();
        return view('admin.owners.edit')->with('owner', $owner);
    }
    //Update table
    public function update(OwnersFormRequest $request)
    {
        $id                    = $request->input('id');
        $owner                 = \App\Owners::find($id);
        $owner->firstname      = $request->get('firstname');
        $owner->lastname       = $request->get('lastname');
        $owner->address_line_1 = $request->get('address_line_1');
        $owner->address_line_2 = $request->get('address_line_2');
        $owner->city           = $request->get('city');
        $owner->state          = $request->get('state');
        $owner->zip            = $request->get('zip');
        $owner->phone          = $request->get('phone');
        $owner->email          = $request->get('email');
        if( !empty($request->get('password')) ){
        $owner->password       = Hash::make( $request->get('password') );
        }
        $owner->notes          = $request->get('notes');
        $owner->display_order  = $request->get('display_order')?$request->get('display_order'):0;
        if ($request->has('is_active')) {
            $owner->is_active = 1;
        } //$request->has('is_active')
        else {
            $owner->is_active = 0;
        }
        $owner->save();
        @$message .= 'Successfully saved.<br/>';
        $fileprefix = 'owner-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $owner->avatar = $filepath . $fileprefix . $filename;
            $owner->save();
            @$message .= 'Picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        $owner->save();
        return redirect('/admin/owners/edit/' . $id)->withMessage($message);
    }
    //Deletes a row
    public function destroy(Request $request, $id)
    {
        $owner = \App\Owners::find($id);
        $owner->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/admin/owners')->with($data);
    }
}
