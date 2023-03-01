<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
// use Auth;

use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\ModelLocations;
use App\Models\PropertiesRates;
use App\Models\Calendar;

class SortableController extends Controller
{
    //Presents draggable table rows for changing display order of a table.
    public function index()
    {
        $model   = session('model');
        $counter = session('counter');
        $data    = urldecode(session('items'));
        parse_str($data);
        for ($i = 0; $i < $counter; $i++) {
            $item_id            = isset($id["$i"]) ? $id["$i"] : '';
            $item_display_order = isset($display_order[$i]) ? $display_order[$i] : '';
            $item_image         = isset($image[$i]) ? $image[$i] : '';
            $item_title         = isset($title[$i]) ? $title[$i] : '';
            $items[]            = (object) array(
                'id' => $item_id,
                'display_order' => $item_display_order,
                'image' => $item_image,
                'title' => $item_title
            );
        } //$i = 0; $i < $counter; $i++
        return view('admin.layouts.objects.sortable')->with('items', $items);
    }
    //Save the actions to database
    //Called through ajax
    public function update()
    {
        $model = session('model');
        $model = "\App\\$model";
        $order = 1;
        foreach ($_GET['id'] as $id) {
            $order++;
        } //$_GET['id'] as $id
        return 'SUCCESS';
    }
}
