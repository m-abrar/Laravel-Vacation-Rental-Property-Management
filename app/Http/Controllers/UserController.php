<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\Categories;
use App\Models\ModelLocations;
use App\Models\PageTypes;
class UserController extends Controller
{
    public function user_posts($id)
    {
        $posts = Posts::where('author_id', $id)->where('active', '1')->orderBy('created_at', 'desc')->paginate(5);
        $title = User::find($id)->name;
        return view('home')->withPosts($posts)->withTitle($title);
    }
    public function user_posts_all(Request $request)
    {
        $user  = $request->user();
        $posts = Posts::where('author_id', $user->id)->orderBy('created_at', 'desc')->paginate(5);
        $title = $user->name;
        return view('home')->withPosts($posts)->withTitle($title);
    }
    public function user_posts_draft(Request $request)
    {
        $user  = $request->user();
        $posts = Posts::where('author_id', $user->id)->where('active', '0')->orderBy('created_at', 'desc')->paginate(5);
        $title = $user->name;
        return view('home')->withPosts($posts)->withTitle($title);
    }
    public function profile(Request $request, $id)
    {
        $data['user'] = User::find($id);
        if (!$data['user'])
            return redirect('/');
        if ($request->user() && $data['user']->id == $request->user()->id) {
            $data['author'] = true;
        } //$request->user() && $data['user']->id == $request->user()->id
        else {
            $data['author'] = null;
        }
        $data['comments_count']     = $data['user']->comments->count();
        $data['posts_count']        = $data['user']->posts->count();
        $data['posts_active_count'] = $data['user']->posts->where('active', '1')->count();
        $data['posts_draft_count']  = $data['posts_count'] - $data['posts_active_count'];
        $data['latest_posts']       = $data['user']->posts->where('active', '1')->take(5);
        $data['latest_comments']    = $data['user']->comments->take(5);
        return view('admin.profile', $data);
    }
}

