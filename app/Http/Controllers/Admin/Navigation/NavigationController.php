<?php
namespace App\Http\Controllers\Admin\Navigation;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NavigationFormRequest;

use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\Categories;
use App\Models\ModelLocations;
use App\Models\PageTypes;


class NavigationController extends Controller
{
    // List of all navigation items with edit/delete/add actions
    public function index($group_name = 'top-bar')
    {
        $navArray      = NavigationController::getNavigationArrayAdmin(0, $group_name);
        $menu          = NavigationController::convertMenu2HtmlAdmin($navArray);
        $menupagetypes = PageTypes::all();
        $js            = "$('#treeview-settings').addClass('active');\n";
        return view('admin.navigation.index')->with('menupagetypes', $menupagetypes)->with('group_name', $group_name)->with('menu', $menu)->with('js', $js);
    }
    //Create an array for a jquery auto complete function for creating URIs in the navigation edit/add form
    public function autocomplete()
    {
        $autocomplete = array();
        $categories   = PageTypes::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        foreach ($categories as $category) {
            array_push($autocomplete, (object) array(
                'title' => $category->title,
                'value' => $category->slug
            ));
        } //$categories as $category
        $pages = Pages::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        foreach ($pages as $page) {
            array_push($autocomplete, (object) array(
                'title' => $page->category->title . ' / ' . $page->title,
                'value' => $page->category->slug . '/' . $page->slug
            ));
        } //$pages as $page
        array_push($autocomplete, (object) array(
            'title' => 'Property Types',
            'value' => 'types'
        ));
        $property_types = PropertyTypes::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        foreach ($property_types as $property_type) {
            array_push($autocomplete, (object) array(
                'title' => 'Type / ' . $property_type->title,
                'value' => 'type/' . $property_type->slug
            ));
        } //$property_types as $property_type
        $properties = Properties::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        foreach ($properties as $property) {
            array_push($autocomplete, (object) array(
                'title' => 'Property / ' . $property->title,
                'value' => 'show/' . $property->slug
            ));
        } //$properties as $property
        return $autocomplete;
    }
    //Add a new navigation menu item
    public function create($group_name)
    {
        $autocomplete = NavigationController::autocomplete();
        return view('admin.navigation.create')->with('autocomplete', $autocomplete)->with('group_name', $group_name);
    }
    //Insert a new item followed by an add form
    public function store(NavigationFormRequest $request)
    {
        $nav                   = new Navigation();
        $nav->title            = $request->get('title');
        $nav->relevant_content = $request->get('relevant_content');
        $nav->value            = $request->get('value');
        $nav->group_name       = 'top-bar'; //$request->get('group_name');
        $nav->is_active        = $request->has('is_active') ? 1 : 0;
        $nav->save();
        $message = 'Successfully saved<br/>';
        return redirect('admin/navigation/edit/' . $nav->id)->withMessage($message);
    }
    //Edit an item through form
    public function edit($id)
    {
        $navigation   = Navigation::where('id', $id)->first();
        $autocomplete = NavigationController::autocomplete();
        return view('admin.navigation.edit')->with('navigation', $navigation)->with('autocomplete', $autocomplete);
    }
    //Update the datababase for submitted form
    public function update(NavigationFormRequest $request)
    {
        $id                    = $request->input('id');
        $nav                   = Navigation::find($id);
        $nav->title            = $request->get('title');
        $nav->relevant_content = $request->get('relevant_content');
        $nav->value            = $request->get('value');
        $nav->group_name       = 'top-bar'; //$request->get('group_name');
        $nav->is_active        = $request->has('is_active') ? 1 : 0;
        $nav->save();
        $message = 'Successfully saved';
        return redirect('/admin/navigation/edit/' . $id)->withMessage($message);
    }
    //Delete an item
    public function destroy(Request $request, $id)
    {
        $nav    = Navigation::find($id);
        $subnav = Navigation::where('parent_id', $nav->id)->get();
        if (count($subnav)) {
            return redirect('/admin/navigation/' . $nav->group_name)->withErrors('The item you are trying to delete has child item(s).')->withInput();
        } //count($subnav)
        $nav->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/admin/navigation/' . $nav->group_name)->with($data);
    }
    //Update the navigation items with checkbox ajax/jquery call function.
    public function updateNavigationStatus(Request $request)
    {
        if ($request->ajax()) {
            $formdata   = $request->get('formdata');
            $group_name = $request->get('group_name');
            $data       = explode('&', $formdata);
            $affected   = Navigation::where('group_name', $group_name)->update(array(
                'is_active' => 0
            ));
            foreach ($data as $row) {
                $row = str_replace('page-', '', $row);
                list($id) = explode('=', $row);
                if (is_numeric($id)) {
                    $affected = Navigation::where('id', $id)->update(array(
                        'is_active' => 1
                    ));
                } //is_numeric($id)
            } //$data as $row
            return 'SUCCESS';
        } //$request->ajax()
    }
    //Receives the form database for updating a navigation items, which is draggable on the view side of admin.
    public function updateNavigationNesting(Request $request)
    {
        if ($request->ajax()) {
            $formdata = $request->get('formdata');
            $data     = (json_decode($formdata, true));
            NavigationController::updateNavigationNestingDB($data);
            return 'SUCCESS';
        } //$request->ajax()
    }
    //Processes the navigation nesting/tree order in the database.
    public function updateNavigationNestingDB($data, $parent_id = '0')
    {
        $loop = 0;
        static $display_order;
        foreach ($data as $foo) {
            $display_order++;
            $id                 = $data[$loop]['id'];
            $nav                = Navigation::find($id);
            $nav->display_order = $display_order;
            $nav->parent_id     = $parent_id;
            $nav->save();
            if (isset($data[$loop]['children'])) {
                NavigationController::updateNavigationNestingDB($data[$loop]['children'], $data[$loop]['id']);
            } //isset($data[$loop]['children'])
            $loop++;
        } //$data as $foo
    }
    //Prepare a multi-dimension array of navigation items for admin to proceed changes through user interface tools.
    public function getNavigationArrayAdmin($parent_id = '0', $group_name = 'top-bar')
    {
        $navigationArray = array();
        $navigationRows  = Navigation::select('id', 'parent_id', 'title', 'is_active', 'display_order')->where('parent_id', $parent_id)->where('group_name', $group_name)->orderBy('display_order', 'asc')->get();
        foreach ($navigationRows as $row) {
            $navigationArray[$row->id]             = array(
                'title' => $row->title,
                'is_active' => $row->is_active,
                'id' => $row->id,
                'display_order' => $row->display_order,
                'children' => array()
            );
            $navigationArray[$row->id]['children'] = NavigationController::getNavigationArrayAdmin($row->id, $group_name);
        } //$navigationRows as $row
        return $navigationArray;
    }
    //Converts the array into html ul.li format.
    private function convertMenu2HtmlAdmin($navArray)
    {
        if (!isset($menu))
            $menu = '';
        $menu .= '<ol class="dd-list">';
        foreach ($navArray as $row) {
            $checked = ($row['is_active'] == '1') ? 'checked="checked"' : '';
            $menu .= '<li class="dd-item dd3-item" data-id="' . $row['id'] . '">';
            $menu .= '<div class="dd-handle dd3-handle">Drag</div>';
            $menu .= '<div class="dd3-content">';
            $menu .= '<a href="' . url('admin/navigation/edit/' . $row['id']) . '">';
            $menu .= html_entity_decode(html_entity_decode($row['title']));
            $menu .= '</a>';
            $menu .= '<div class="dd3-status">';
            $menu .= '<input type="checkbox" class="page-status" name="page-' . $row['id'] . '" ' . $checked . ' />';
            $menu .= '</div>';
            $menu .= '</div>';
            if (count($row['children'])) {
                $menu .= NavigationController::convertMenu2HtmlAdmin($row['children']);
            } //count($row['children'])
            $menu .= '</li>';
        } //$navArray as $row
        $menu .= '</ol>';
        return $menu;
    }
}
