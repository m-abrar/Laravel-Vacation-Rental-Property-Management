<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


use Mail;
use App\Posts;
use App\User;
use Redirect;
use App\Http\Controllers\SendEmailsController as SendEmails;
use App\Http\Controllers\NavigationController as Nav;
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
    //Homepage of the website.
    public function home(SendEmails $sendemails, Nav $nav)
    {
        $sliders           = Sliders::where('is_active', 1)->get();
        $page_home         = Pages::where('is_active', 1)->where('is_home', 1)->orderBy(\DB::raw('RAND()'))->first();
        $pages_featured    = Pages::where('is_active', 1)->where('is_featured', 1)->orderBy(\DB::raw('RAND()'))->take(3)->get();
        $properties        = Properties::where('is_active', 1)->where('is_featured', 1)->orderBy(\DB::raw('RAND()'))->take(6)->get();
        





        $ourlocations      = Pages::where('is_active', 1)->where('is_featured', 1)->where('category_id', 9)->orderBy(\DB::raw('RAND()'))->take(6)->get();
        $ourservices      = Pages::where('is_active', 1)->where('is_featured', 1)->where('category_id', 5)->orderBy(\DB::raw('RAND()'))->take(6)->get();
        $ourpartners      = Pages::where('is_active', 1)->where('is_featured', 1)->where('category_id', 10)->orderBy(\DB::raw('RAND()'))->get();
       // $locations         = \App\ModelLocations::where('is_active', 1)->orderBy('display_order', 'asc')->get();



       


        $settings          = Settings::find(1);
        $menu_top          = $nav->getHTMLNavigation();
        $categories        = Categories::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $locations         = ModelLocations::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $footer_pages      = Pages::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        $footer_properties = Properties::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();

        return view('pages.home')->with('settings', $settings)->with('menu_top', $menu_top)
        ->with('categories', $categories)->with('locations', $locations)
        ->with('sliders', $sliders)->with('page_home', $page_home)
        ->with('properties', $properties)->with('pages_featured', $pages_featured)
        ->with('ourservices', $ourservices)->with('ourpartners', $ourpartners)->with('ourlocations', $ourlocations)
        ->with('footer_pages', $footer_pages)->with('footer_properties', $footer_properties);
    }
   
    //Shows list of contents pages under a specific category.
    public function posts(Nav $nav)
    {
        
        
        $pages             = Pages::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        
        $settings          = Settings::find(1);
        $menu_top          = $nav->getHTMLNavigation();
        $categories        = Categories::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $locations         = ModelLocations::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $footer_pages      = Pages::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        $footer_properties = Properties::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();

        return view('pages.posts')->with('settings', $settings)->with('menu_top', $menu_top)
        ->with('categories', $categories)->with('locations', $locations)
        ->with('pages', $pages)
        ->with('footer_pages', $footer_pages)->with('footer_properties', $footer_properties);
    }
    //Shows list of contents pages under a specific category.
    public function category($category, Nav $nav)
    {
        
        $category          = PageTypes::where('slug', $category)->first();
        $pages             = Pages::where('category_id', $category->id)->where('is_active', 1)->orderBy('display_order', 'asc')->get();
        
        $settings          = Settings::find(1);
        $menu_top          = $nav->getHTMLNavigation();
        $categories        = Categories::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $locations         = ModelLocations::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $footer_pages      = Pages::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        $footer_properties = Properties::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();

        return view('pages.category')->with('settings', $settings)->with('menu_top', $menu_top)
        ->with('categories', $categories)->with('locations', $locations)
        ->with('category', $category)->with('pages', $pages)
        ->with('footer_pages', $footer_pages)->with('footer_properties', $footer_properties);
    }
    //Shows a specific contents page.
    public function show($category, $slug, Nav $nav)
    {
        $category          = PageTypes::where('slug', $category)->first();
        $page              = Pages::where('category_id', $category->id)->where('slug', $slug)->where('is_active', 1)->first();
        $settings          = Settings::find(1);
        $menu_top          = $nav->getHTMLNavigation();
        $categories        = Categories::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $locations         = ModelLocations::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $footer_pages      = Pages::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        $footer_properties = Properties::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        return view('pages.page')->with('settings', $settings)->with('menu_top', $menu_top)
        ->with('categories', $categories)->with('locations', $locations)
        ->with('category', $category)->with('page', $page)
        ->with('footer_pages', $footer_pages)->with('footer_properties', $footer_properties);
    }
    //The contact page of the website.
    public function contact(Nav $nav)
    {
        $settings          = Settings::find(1);
        $menu_top          = $nav->getHTMLNavigation();
        $categories        = Categories::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $locations         = ModelLocations::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $footer_pages      = Pages::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        $footer_properties = Properties::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        return view('pages.contact')->with('settings', $settings)->with('menu_top', $menu_top)
        ->with('categories', $categories)->with('locations', $locations)
        ->with('footer_pages', $footer_pages)->with('footer_properties', $footer_properties);
    }
}
