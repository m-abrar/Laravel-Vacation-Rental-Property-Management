<?php
namespace App\Http\Controllers\Admin\Pages;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PagesFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\Categories;
use App\Models\ModelLocations;
use App\Models\PageTypes;

class PagesController extends Controller
{
    //List of contents pages with actions for edit/delete/add
    public function index(Panel $panel)
    {


        $settings      = Settings::find(1);
        $user          = Auth::user();
        $notifications = $panel->notifications();
        $pages         = Pages::orderBy('display_order', 'asc')->get();
        $js            = "$('#treeview-website').addClass('active');\n";
        return view('admin.pages.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('pages', $pages)->with('js', $js);
    }
    //Create form for adding a new content page
    public function create()
    {
        $categories = PageTypes::where('is_active', '1')->get();
        return view('admin.pages.create')->with('categories', $categories);
    }
    //Inserts the page contents into database.
    public function store(PagesFormRequest $request)
    {
        $page        = new Pages();
        $page->title = $request->input('title');
        $page->slug  = $slug = str_slug($page->title);
        $duplicate   = Pages::where('slug', $slug)->first();
        if ($duplicate)
            return redirect('/admin/pages/create')->withErrors('Slug must not be already used.')->withInput();
        list($message, $error, $id) = PagesController::save($request, $page);
        return redirect('/admin/pages/edit/' . $id)->withMessage($message)->withErrors($error);
    }
    //Shows edit form for a page contents.
    public function edit($id)
    {
        $page       = Pages::where('id', $id)->first();
        $images     = PagesImages::where('page_id', $page->id)->get(); //abrar is_active
        $categories = PageTypes::where('is_active', '1')->get();
        return view('admin.pages.edit')->with('page', $page)->with('images', $images)->with('categories', $categories);
    }
    //Common part of code in both update/insert.
    public function save($request, $page)
    {
        $page->category_id   = $request->input('category_id');
        $page->is_active     = $request->has('is_active') ? '1' : '0';
        $page->is_featured   = $request->has('is_featured') ? '1' : '0';
        $page->is_new        = $request->has('is_new') ? '1' : '0';
        $page->is_home       = $request->has('is_home') ? '1' : '0';
        $page->display_order = $request->input('display_order');
        $page->summary       = $request->input('summary');
        $page->contents      = $request->input('contents');
        $page->save();
        @$message .= 'Page has been successfully saved.<br/>';
        $page_id = $page->id;
        if (!empty($page_id)) {
            for ($i = 1; $i <= $request->input('images_total'); $i++) {
                if ($request->has('picture_delete_' . $i)) {
                    $PImage = PagesImages::find($request->get('picture_delete_' . $i));
                    $PImage->delete();
                } //$request->has('picture_delete_' . $i)
                if ($request->get('image_db_id_' . $i) != 'NA') {
                    $pageImage = PagesImages::find($request->get('image_db_id_' . $i));
                } //$request->get('image_db_id_' . $i) != 'NA'
                else {
                    $pageImage = new PagesImages();
                }
                $fileprefix = $page->category->slug . '-';
                $filepath   = 'pictures/';
                $filename   = str_replace('tmp/', '', $request->input('tmp_img_path_' . $i));
                if (is_file('tmp/' . $filename)) {
                    \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
                    $pageImage->page_id   = $page_id;
                    $pageImage->image     = $filepath . $fileprefix . $filename;
                    $pageImage->is_active = '1';
                    $pageImage->save();
                    @$message .= 'Image saved: ' . $pageImage->image . ' <br/>';
                } //is_file('tmp/' . $filename)
            } //$i = 1; $i <= $request->input('images_total'); $i++
            $page->save();
        } //!empty($page_id)
        return array(
            @$message,
            @$error,
            $page_id //insert id
        );
    }
    //Update the table for edit form
    public function update(PagesFormRequest $request)
    {
        $id          = $request->input('id');
        $page        = Pages::find($id);
        $page->title = $request->input('title');
        $page->slug  = $slug = str_slug($page->title);
        $duplicate   = Pages::where('slug', $slug)->where('id', '!=', $id)->first();
        if ($duplicate)
            return redirect('/admin/pages/edit/' . $id)->withErrors('Slug must not be already used.')->withInput();
        //Call the rest of code through save()
        list($message, $error, $id) = PagesController::save($request, $page);
        return redirect('/admin/pages/edit/' . $id)->withMessage($message)->withErrors($error);
    }
    //Delete the contents and its images.
    public function destroy(Request $request, $id)
    {
        //deletes from database rows and not from the files.
        $PImage = PagesImages::where('page_id', $id);
        $PImage->delete();
        $page = Pages::find($id);
        $page->delete();
        $message = 'page deleted<br/>';
        return redirect('/admin/pages/index')->withMessage($message);
    }
}
