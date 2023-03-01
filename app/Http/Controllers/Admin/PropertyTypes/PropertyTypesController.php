<?php
namespace App\Http\Controllers\Admin\PropertyTypes;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyTypesFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
// use Auth;

use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\ModelLocations;
use App\Models\PropertyTypes;
use App\Models\ModelCalendar;

class PropertyTypesController extends Controller
{
    public function getPropertyTypeID($slug){
        $category    = PropertyTypes::where('slug', $slug)->first();
        return $category->id;
    }


    //List of categories/types of properties with actions to edit/delete
    public function index(Panel $panel)
    {
        $settings      = Settings::find(1);
        $user          = Auth::user();
        $notifications = $panel->notifications();
        $propertytypes = PropertyTypes::orderBy('display_order', 'asc')->get();
        $js            = "$('#treeview-properties').addClass('active');\n";
        return view('admin.property-types.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('propertytypes', $propertytypes)->with('js', $js);
    }
    //Form for adding a new category of properties to the system
    public function create()
    {
        return view('admin.property-types.create');
    }
    //Inserts a new record into database
    public function store(PropertyTypesFormRequest $request)
    {
        $propertytypes            = new PropertyTypes();
        $propertytypes->title     = $request->get('title');
        $propertytypes->is_active = $request->has('is_active') ? 1 : 0;
        $propertytypes->save();
        @$message .= 'Property type added.<br/>';
        $fileprefix = 'property-type-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $propertytypes->image = $filepath . $fileprefix . $filename;
            $propertytypes->save();
            @$message .= 'Picture saved.<br/>';


                        $source = $filepath.$fileprefix.$filename;
                            $filesmall = $filepath.$fileprefix.'small-'.$filename;
                            $percent = 0.5;

                            // Get new sizes
                            list($width, $height) = getimagesize($source);
                   
                            $newwidth = $width * $percent;
                            $newheight = $height * $percent;
                        
                            $source = imagecreatefrompng($source);
                            $dest = imagecreatetruecolor($newwidth, $newheight);
                            imagealphablending($dest, false);
                            imagesavealpha($dest,true);
                            $transparent = imagecolorallocatealpha($dest, 255, 255, 255, 127);
                            imagefilledrectangle($dest, 0, 0, $newwidth, $newheight, $transparent);
                            $result = imagecopyresampled($dest, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                            if ($result) {
                            if (!imagepng($dest,$filesmall)) {
                            @$error .= "Failed to save the resized image file";
                            } //
                            } //$result
                            else {
                            @$error .= "Failed to resize the image file";
                            }

                            imagedestroy($source);
                            imagedestroy($dest);
                                
                        $propertytypes->image_small       = $filesmall;
                        $propertytypes->save();
                        @$success .= 'Small image saved: ' . $propertytypes->image_small . ' <br/>';




        } //is_file('tmp/' . $filename)
        return redirect('admin/property-types/edit/' . $propertytypes->id)->withMessage($message);
    }
    //Edit form for a specific database row
    public function edit($id)
    {
        $propertytype = PropertyTypes::where('id', $id)->first();
        return view('admin.property-types.edit')->with('propertytype', $propertytype);
    }
    //Update the specified row of the property types table.
    public function update(PropertyTypesFormRequest $request)
    {
        $id                   = $request->input('id');
        $propertytypes        = PropertyTypes::find($id);
        $propertytypes->title = $request->input('title');
        @$message .= 'Property type updated.<br/>';
        $propertytypes->is_active = $request->has('is_active') ? 1 : 0;
        $propertytypes->save();
        $fileprefix = 'property-type-';
        $filepath   = 'pictures/';
        $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_main'));
        if (is_file('tmp/' . $filename)) {
            \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
            $propertytypes->image = $filepath . $fileprefix . $filename;
            $propertytypes->save();
            @$message .= 'Picture saved.<br/>';


                $source = $filepath.$fileprefix.$filename;
                $filesmall = $filepath.$fileprefix.'small-'.$filename;
                $percent = 0.5;

                // Get new sizes
                list($width, $height) = getimagesize($source);

                $newwidth = $width * $percent;
                $newheight = $height * $percent;

                $source = imagecreatefrompng($source);
                $dest = imagecreatetruecolor($newwidth, $newheight);
                imagealphablending($dest, false);
                imagesavealpha($dest,true);
                $transparent = imagecolorallocatealpha($dest, 255, 255, 255, 127);
                imagefilledrectangle($dest, 0, 0, $newwidth, $newheight, $transparent);
                $result = imagecopyresampled($dest, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                if ($result) {
                if (!imagepng($dest,$filesmall)) {
                @$error .= "Failed to save the resized image file";
                } //
                } //$result
                else {
                @$error .= "Failed to resize the image file";
                }

                imagedestroy($source);
                imagedestroy($dest);

                $propertytypes->image_small       = $filesmall;
                $propertytypes->save();
                @$success .= 'Small image saved: ' . $propertytypes->image_small . ' <br/>';


        } //is_file('tmp/' . $filename)
        return redirect('/admin/property-types/edit/' . $id)->withMessage($message);
    }
    //Delete a row
    //Properties that belong to this category will still remain on the database.
    public function destroy(Request $request, $id)
    {
        $propertytypes = PropertyTypes::find($id);
        $propertytypes->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/admin/property-types')->with($data);
    }
}
