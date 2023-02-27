<?php
namespace App\Http\Controllers\Admin\Users;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;
class UserController extends Controller
{
    //Edit form
    public function edit(Panel $panel)
    {
        //load edit form right on index.
        $settings      = \App\Settings::find(1);
        $user          = \Auth::user();
        $notifications = $panel->notifications();
        $js            = "$('#treeview-settings').addClass('active');\n";
        return view('admin.users.edit')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('js', $js);
    }
    //Update the database
    public function update(UserFormRequest $request, Panel $panel)
    {
        
        $user_session  = \Auth::user();
        $notifications = $panel->notifications();
        $id = $user_session->id;
        $user              = \App\User::find($id);
        $user->firstname   = $request->input('firstname');
        $user->lastname    = $request->input('lastname');
        $user->designation = $request->input('designation');
        $user->username    = $request->input('username');
        $user->email    = $request->input('email');
        $password          = $request->input('password');
        $password_confirm  = $request->input('password_confirm');
        if (!empty($password)) {
            if ($password == $password_confirm) {
                $user->password = \Hash::make($password);
            } //$password == $password_confirm
            else {
                return redirect('/admin/users')->withErrors('The password confirmation failed!')->withInput();
            }
        } //!empty($password)
        $user->save();
        @$message .= 'User profile successfully updated.<br/>';
        $fileprefix = 'user-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_avatar'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $user->avatar = $filepath . $fileprefix . $filename;
            $user->save();
            @$message .= 'Avatar picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        return redirect('/admin/users')->withMessage($message);
    }
}
