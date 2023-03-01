<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\Auth;

use App\Models\Settings;
use App\Models\Navigation;
use App\Models\Sliders;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\Categories;
use App\Models\ModelLocations;
use App\Models\PageTypes;

class NavigationController extends Controller
{
    //Call this function to return navigation group shaped in ul.li html format.
    public function getHTMLNavigation($parent_id = 0, $group_name = 'top-bar', $active_url = 'none', $prefix = 'top_nav_') //
    {
        return NavigationController::convertMenu2Html(NavigationController::getNavigationArray($parent_id, $group_name, $active_url, $prefix), $active_url, $prefix);
    }
    //Step-1 of creating a navigation menu
    //Reads the database table and returns multi-dimentional array.
    public function getNavigationArray($parent_id, $group_name, $active_url, $prefix)
    {
        $navigationArray = array();
        $navigationRows  = Navigation::select('id', 'group_name', 'parent_id', 'title', 'page_type_id', 'value')->where('is_active', 1)->where('parent_id', $parent_id)->where('group_name', $group_name)->orderBy('display_order', 'asc')->get();
        foreach ($navigationRows as $row) {
            if (!filter_var($row->value, FILTER_VALIDATE_URL) === false) {
                $url = $row->value;
            } //!filter_var($row->value, FILTER_VALIDATE_URL) === false
            elseif (empty($row->value)) {
                $url = '#';
            } //empty($row->value)
            else {
                $pageType = PageTypes::select('slug')->where('id', $row->page_type_id)->first();
                $url      = isset($pageType->slug) ? $pageType->slug . '/' . $row->value : $row->value;
                $url      = url($url);
            }
            $navigationArray[$row->id]             = array(
                'title' => $row->title,
                'url' => $url,
                'id' => $row->id,
                'children' => array()
            );
            $navigationArray[$row->id]['children'] = NavigationController::getNavigationArray($row->id, $group_name, $active_url, $prefix);
        } //$navigationRows as $row
        return $navigationArray;
    }

    //Converts the navigation array into an html format ul.li
    private function convertMenu2Html($array, $active_url, $prefix)
    {
        if (!isset($menu))
            $menu = '';
        $menu .= '<ul>';
        foreach ($array as $item) {
            $class = 'class="';
            $class .= ($item['url'] == $active_url) ? ' active ' : '';
            $class .= (count($item['children']) > 0) ? ' has-sub ' : '';
            $class .= '"';
            $arrow_active = ($item['url'] == $active_url) ? '&#10148; ' : '';
            $menu .= '<li id="' . $prefix . $item['id'] . '" ' . $class . ' >';
            $menu .= '<a href="' . $item['url'] . '">';
            $menu .= $arrow_active . $item['title'];
            $menu .= '</a>';
            if (count($item['children'])) {
                $menu .= NavigationController::convertMenu2Html($item['children'], $active_url, $prefix);
            } //count($item['children'])
            $menu .= '</li>';
        } //$array as $item
        $menu .= '</ul>';
        return $menu;
    }
    //Find the id of parent of a navigation element
    //We can on the views apply css active class or do other operations of database too.
    public function getNavigationParentID($nav_id = '0')
    {
        if ($nav_id == '0')
            return 0;
        $navResult = \App\Navigation::select('id', 'parent_id')->where('id', $nav_id)->first();
        return $navResult->parent_id;
    }
    //Find the id of grand parent of a navigation element
    //We can on the views apply css active class or do other operations of database too.
    public function getNavigationGrandParentID($nav_id = '0')
    {
        if ($nav_id == '0')
            return 0;
        $navRows = \App\Navigation::select('id', 'parent_id')->where('id', $nav_id)->first();
        if ($navRows->parent_id == '0') {
            return $navRows->id;
        } //$navRows->parent_id == '0'
        else {
            return NavigationController::getNavigationGrandParentID($navRows->parent_id);
        }
    }
}