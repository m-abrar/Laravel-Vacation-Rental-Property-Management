<?php
namespace App\Http\Controllers\Admin\EmailTemplates;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailTemplatesFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;
use Auth;

use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\ModelLocations;
use App\Models\PropertiesRates;
use App\Models\Calendar;
use App\Models\EmailTemplates;


class EmailTemplatesController extends Controller
{
    //List of email templates available with edit action
    public function index(Panel $panel)
    {
        $settings       = Settings::find(1);
        $user           = Auth::user();
        $notifications  = $panel->notifications();
        $emailtemplates = EmailTemplates::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $js             = "$('#treeview-settings').addClass('active');\n";
        return view('admin.email-templates.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('emailtemplates', $emailtemplates)->with('js', $js);
    }
    //Shows edit form
    public function edit($id)
    {
        $emailtemplate = EmailTemplates::where('id', $id)->first();
        //dd($emailtemplate);
        return view('admin.email-templates.edit')->with('emailtemplate', $emailtemplate);
    }
    //Saves the changes into database
    public function update(EmailTemplatesFormRequest $request)
    {
        $id                           = $request->input('id');
        $emailtemplate                = EmailTemplates::find($id);
        $emailtemplate->email_subject = $request->input('email_subject');
        $emailtemplate->email_body    = $request->input('email_body');
        @$message .= 'Successfully saved<br/>';
        $emailtemplate->save();
        return redirect('/admin/email-templates/edit/' . $id)->withMessage($message);
    }
}
