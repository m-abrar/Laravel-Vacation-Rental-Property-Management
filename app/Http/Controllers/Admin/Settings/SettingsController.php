<?php
namespace App\Http\Controllers\Admin\Settings;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;
class SettingsController extends Controller
{
    //Form for updating settings
    public function edit(Panel $panel)
    {
        //load edit form right on index.
        $settings      = \App\Settings::find(1);
        $user          = \Auth::user();
        $notifications = $panel->notifications();
        $setting       = \App\Settings::where('id', 1)->first();
        $js            = "$('#treeview-settings').addClass('active');\n";
        return view('admin.settings.edit')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('setting', $setting)->with('js', $js);
    }
    //Update the settings table for form submitted.
    public function update(SettingsFormRequest $request)
    {
        $id                           = $request->input('id');
        $setting                      = \App\Settings::find($id);
        $setting->site_title          = $request->input('site_title');
        $setting->site_address_line_1 = $request->input('site_address_line_1');
        $setting->site_address_line_2 = $request->input('site_address_line_2');
        $setting->site_email          = $request->input('site_email');
        $setting->site_phone          = $request->input('site_phone');
        $setting->latitude            = $request->input('latitude');
        $setting->longitude           = $request->input('longitude');
        $setting->site_url            = $request->input('site_url');
        $setting->facebook            = $request->input('facebook');
        $setting->twitter             = $request->input('twitter');
        $setting->linkedin            = $request->input('linkedin');
        $setting->googleplus          = $request->input('googleplus');
        $setting->payment_mode        = $request->input('payment_mode');
        $setting->stripe_public_key   = $request->input('stripe_public_key');
        $setting->stripe_secret_key   = $request->input('stripe_secret_key');
        $setting->chat_script         = $request->input('chat_script');
        $setting->google_analytics    = $request->input('google_analytics');
        $setting->google_map_api_key  = $request->input('google_map_api_key');
        $setting->business_hours      = $request->input('business_hours');
        $setting->site_header_top     = $request->input('site_header_top');
        $setting->site_header         = $request->input('site_header');
        $setting->site_footer         = $request->input('site_footer');

        $setting->theme_options_color         = $request->input('theme_options_color');
        $setting->theme_options_header        = $request->input('theme_options_header');
        $setting->theme_options_hero        = $request->input('theme_options_hero');
        $setting->theme_options_home         = $request->input('theme_options_home');
        $setting->theme_options_frontend_control    = $request->has('theme_options_frontend_control') ? '1' : '0';

        $setting->is_site_live        = $request->has('is_site_live') ? '1' : '0';
        $setting->sale_policies       = $request->input('sale_policies');
        $setting->is_sale_policies    = $request->has('is_sale_policies') ? '1' : '0';
        $setting->rental_policies     = $request->input('rental_policies');
        $setting->is_rental_policies  = $request->has('is_rental_policies') ? '1' : '0';
        $setting->save();
        @$message .= 'Settings successfully updated.<br/>';
        $fileprefix = 'site-avatar-';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_avatar'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, 'admin/img/' . $fileprefix . $filename);
            $setting->avatar = $fileprefix . $filename;
            $setting->save();
            @$message .= 'Avatar picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        $fileprefix = 'site-logo-';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_logodark'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, 'img/' . $fileprefix . $filename);
            $setting->logo_dark = $fileprefix . $filename;
            $setting->save();
            @$message .= 'Dark Logo picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_logolight'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, 'img/' . $fileprefix . $filename);
            $setting->logo_light = $fileprefix . $filename;
            $setting->save();
            @$message .= 'Light Logo picture saved.<br/>';
        } //is_file('tmp/' . $filename)
        return redirect('/admin/settings')->withMessage($message);
    }
}
