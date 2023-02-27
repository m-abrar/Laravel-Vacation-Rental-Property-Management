<?php
namespace App\Http\Controllers\Admin\EmailTemplates;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailTemplatesFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;
class EmailTemplatesController extends Controller
{
    //List of email templates available with edit action
    public function index(Panel $panel)
    {
        $settings       = \App\Settings::find(1);
        $user           = \Auth::user();
        $notifications  = $panel->notifications();
        $emailtemplates = \App\EmailTemplates::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $js             = "$('#treeview-settings').addClass('active');\n";
        return view('admin.email-templates.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('emailtemplates', $emailtemplates)->with('js', $js);
    }
    //Shows edit form
    public function edit($id)
    {
        $emailtemplate = \App\EmailTemplates::where('id', $id)->first();
        //dd($emailtemplate);
        return view('admin.email-templates.edit')->with('emailtemplate', $emailtemplate);
    }
    //Saves the changes into database
    public function update(EmailTemplatesFormRequest $request)
    {
        $id                           = $request->input('id');
        $emailtemplate                = \App\EmailTemplates::find($id);
        $emailtemplate->email_subject = $request->input('email_subject');
        $emailtemplate->email_body    = $request->input('email_body');
        @$message .= 'Successfully saved<br/>';
        $emailtemplate->save();
        return redirect('/admin/email-templates/edit/' . $id)->withMessage($message);
    }
}
