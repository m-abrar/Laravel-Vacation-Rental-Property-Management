<?php
namespace App\Http\Controllers;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SelectDatesController as SelectDates;
use App\Http\Controllers\NavigationController as Nav;
// use App\Http\Controllers\Admin\PropertyTypes\PropertyTypesController as PropertyTypes;
use App\Http\Controllers\Admin\Locations\LocationsController as Locations;
use App\Http\Requests\FrontendPropertiesSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Settings;
use App\Models\Pages;
use App\Models\Properties;
use App\Models\Categories;
use App\Models\ModelLocations;
use App\Models\LineItems;
use App\Models\Seasons;
use App\Models\Amenities;
use App\Models\Features;
use App\Models\PropertyTypes;


class PropertiesController extends Controller
{
    //Shows view page of a property detail
    public function show(Request $request, Nav $nav, $slug, $pre_select_date_start = 'NA', $pre_select_date_end = 'NA')
    {
        $property    = Properties::where('slug', $slug)->first();
        $property_id = $property->id;
        $amenities = Amenities::where('is_active', 1)->with(array(
            'added' => function($query) use ($property_id)
            {
                $query->where('property_id', $property_id)->get();
            }
        ))->orderBy('display_order', 'asc')->get();
        $features = Features::where('is_active', 1)->with(array(
            'added' => function($query) use ($property_id)
            {
                $query->where('property_id', $property_id)->get();
            }
        ))->orderBy('display_order', 'asc')->get();
        $ratesX   = \DB::table('emt_seasons as S')->where('S.is_active', '1')->leftJoin('emt_properties_rates as PR', 'S.id', '=', 'PR.season_id')->where('PR.property_id', $property->id)->orderBy('S.display_order', 'asc')->groupBy('S.id')->get();
        $rates             = Seasons::where('is_active', 1)->with(array(
            'added' => function($query) use ($property_id)
            {
                $query->where('property_id', $property_id)->get();
            }
        ))->orderBy('display_order', 'asc')->get();
        $lineitems         = LineItems::where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $settings          = Settings::find(1);
        $menu_top          = $nav->getHTMLNavigation();
        $categories        = Categories::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $locations         = ModelLocations::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $footer_pages      = Pages::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        $footer_properties = Properties::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        return view('properties.show')->with('settings', $settings)->with('menu_top', $menu_top)
        ->with('categories', $categories)->with('locations', $locations)
        ->with('property', $property)->with('amenities', $amenities)
        ->with('features', $features)->with('rates', $rates)
        ->with('lineitems', $lineitems)->with('pre_select_date_start', $pre_select_date_start)
        ->with('pre_select_date_end', $pre_select_date_end)
        ->with('footer_pages', $footer_pages)->with('footer_properties', $footer_properties);
    }
    //Shows view page of a property detail for Sale
    public function showSale(Request $request, Nav $nav, $slug, $pre_select_date_start = 'NA', $pre_select_date_end = 'NA')
    {
        $property    = Properties::where('slug', $slug)->first();
        $property_id = $property->id;
        $amenities = Amenities::where('is_active', 1)->with(array(
            'added' => function($query) use ($property_id)
            {
                $query->where('property_id', $property_id)->get();
            }
        ))->orderBy('display_order', 'asc')->get();
        $features = Features::where('is_active', 1)->with(array(
            'added' => function($query) use ($property_id)
            {
                $query->where('property_id', $property_id)->get();
            }
        ))->orderBy('display_order', 'asc')->get();
        $ratesX   = \DB::table('emt_seasons as S')->where('S.is_active', '1')->leftJoin('emt_properties_rates as PR', 'S.id', '=', 'PR.season_id')->where('PR.property_id', $property->id)->orderBy('S.display_order', 'asc')->groupBy('S.id')->get();
        $rates             = Seasons::where('is_active', 1)->with(array(
            'added' => function($query) use ($property_id)
            {
                $query->where('property_id', $property_id)->get();
            }
        ))->orderBy('display_order', 'asc')->get();
        $lineitems         = LineItems::where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $settings          = Settings::find(1);
        $menu_top          = $nav->getHTMLNavigation();
        $categories        = Categories::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $locations         = ModelLocations::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $footer_pages      = Pages::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        $footer_properties = Properties::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        return view('properties.show-sale')->with('settings', $settings)->with('menu_top', $menu_top)
        ->with('categories', $categories)->with('locations', $locations)
        ->with('property', $property)->with('amenities', $amenities)
        ->with('features', $features)->with('rates', $rates)
        ->with('lineitems', $lineitems)->with('pre_select_date_start', $pre_select_date_start)
        ->with('pre_select_date_end', $pre_select_date_end)
        ->with('footer_pages', $footer_pages)->with('footer_properties', $footer_properties);
    }
    //Shows view page of a property detail for reservation
    public function showReserve(Request $request, Nav $nav, $slug, $pre_select_date_start = 'NA', $pre_select_date_end = 'NA')
    {
        $property    = Properties::where('slug', $slug)->first();
        $property_id = $property->id;
        $amenities = Amenities::where('is_active', 1)->with(array(
            'added' => function($query) use ($property_id)
            {
                $query->where('property_id', $property_id)->get();
            }
        ))->orderBy('display_order', 'asc')->get();
        $features = Features::where('is_active', 1)->with(array(
            'added' => function($query) use ($property_id)
            {
                $query->where('property_id', $property_id)->get();
            }
        ))->orderBy('display_order', 'asc')->get();
        $ratesX   = \DB::table('emt_seasons as S')->where('S.is_active', '1')->leftJoin('emt_properties_rates as PR', 'S.id', '=', 'PR.season_id')->where('PR.property_id', $property->id)->orderBy('S.display_order', 'asc')->groupBy('S.id')->get();
        $rates             = Seasons::where('is_active', 1)->with(array(
            'added' => function($query) use ($property_id)
            {
                $query->where('property_id', $property_id)->get();
            }
        ))->orderBy('display_order', 'asc')->get();
        $lineitems         = LineItems::where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $settings          = Settings::find(1);
        $menu_top          = $nav->getHTMLNavigation();
        $categories        = Categories::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $locations         = ModelLocations::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $footer_pages      = Pages::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        $footer_properties = Properties::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        return view('properties.show-reserve')->with('settings', $settings)->with('menu_top', $menu_top)
        ->with('categories', $categories)->with('locations', $locations)
        ->with('property', $property)->with('amenities', $amenities)
        ->with('features', $features)->with('rates', $rates)
        ->with('lineitems', $lineitems)->with('pre_select_date_start', $pre_select_date_start)
        ->with('pre_select_date_end', $pre_select_date_end)
        ->with('footer_pages', $footer_pages)->with('footer_properties', $footer_properties);
    }



    //Shows categories/types for properties to chose one.
    public function types(Nav $nav)
    {
        $categories        = PropertyTypes::where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $locations         = ModelLocations::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        
        $settings          = Settings::find(1);
        $menu_top          = $nav->getHTMLNavigation();
        $footer_pages      = Pages::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        $footer_properties = Properties::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        return view('properties.types')->with('settings', $settings)->with('menu_top', $menu_top)
        ->with('categories', $categories)->with('locations', $locations)
        ->with('footer_pages', $footer_pages)->with('footer_properties', $footer_properties);
    }
    //Shows properties under a specific category/type
    public function indexByType($slug, Nav $nav)
    {
        $category          = PropertyTypes::where('slug', $slug)->first();
        $locations         = ModelLocations::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $properties        = Properties::where('category_id', $category->id)->where('is_active', '1')->orderBy('display_order', 'asc')->get();
        
        $settings          = Settings::find(1);
        $menu_top          = $nav->getHTMLNavigation();
        $categories        = Categories::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $footer_pages      = Pages::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        $footer_properties = Properties::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        return view('properties.type')->with('settings', $settings)->with('menu_top', $menu_top)
        ->with('categories', $categories)->with('locations', $locations)
        ->with('category', $category)->with('properties', $properties)
        ->with('footer_pages', $footer_pages)->with('footer_properties', $footer_properties);
    }
    //Searches vacation properties available for booking between given dates.
    public function saleSearchRedirect(FrontendPropertiesSearch $request)
    {
            $type = (null!==@$request->get('category'))?$request->get('category'):'all';
            $location = (null!==@$request->get('location'))?$request->get('location'):'all';
            return redirect('sale/search/' . $type . '/' . $location . '/' . $request->input('sleeps'));
    }
    public function saleSearch(Nav $nav, PropertyTypes $propertytypes, Locations $locations, $type = 'all', $location = 'all', $sleeps = '1')
    {

        if($type=='all' AND $location=='all'){

                $properties = Properties::where('is_active', 1)
                ->where('is_sale', 1)
                ->where('sleeps', '>=', $sleeps)
                ->orderBy('display_order','asc')->get();

                //dd(__LINE__. $properties );

        }elseif($type<>'all' AND $location=='all'){

                $category_id = $propertytypes->getPropertyTypeID($type);
                $properties = Properties::where('is_active', 1)
                ->where('is_sale', 1)
                ->where('sleeps', '>=', $sleeps)
                ->where('category_id', $category_id)
                ->orderBy('display_order','asc')->get();

        }elseif($type=='all' AND $location<>'all'){

                $location_id = $locations->getLocationID($location);
                $properties = Properties::where('is_active', 1)
                ->where('is_sale', 1)
                ->where('sleeps', '>=', $sleeps)
                ->where('state_id', $location_id)
                ->orderBy('display_order','asc')->get();

        }else{

                $location_id = $locations->getLocationID($location);
                $category_id = $propertytypes->getPropertyTypeID($type);
                $properties = Properties::where('is_active', 1)
                ->where('is_sale', 1)
                ->where('sleeps', '>=', $sleeps)
                ->where('state_id', $location_id)
                ->where('category_id', $category_id)
                ->orderBy('display_order','asc')->get();
        }  

        $settings          = Settings::find(1);
        $menu_top          = $nav->getHTMLNavigation();
        $categories        = Categories::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $locations         = ModelLocations::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $footer_pages      = Pages::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        $footer_properties = Properties::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        return view('properties.search-sale')->with('settings', $settings)->with('menu_top', $menu_top)
        ->with('categories', $categories)->with('locations', $locations)->with('selectedtype', $type)->with('selectedlocation', $location)
        ->with('sleeps', $sleeps)->with('properties', $properties)
        ->with('footer_pages', $footer_pages)->with('footer_properties', $footer_properties);
    }

    //Searches vacation properties available for booking between given dates.
    public function rentalSearchRedirect(FrontendPropertiesSearch $request)
    {
        if ( null!==@$request->get('arrival') and null!==@$request->get('departure') ) {
            
            if(empty($request->get('arrival')) or empty($request->get('departure'))){
                return redirect('rental/search')->withErrors('Search fields can not be empty')->withInput();
            }
            $type = (null!==@$request->get('category'))?$request->get('category'):'all';
            return redirect('rental/search/' . $type . '/' . date('Y-m-d', strtotime($request->input('arrival'))) . '/' . date('Y-m-d', strtotime($request->input('departure'))) . '/' . $request->input('sleeps'));
        } //empty($date_start) or empty($date_end)    //Searches vacation properties available for booking between given dates.
    }
    public function rentalSearch(Nav $nav, SelectDates $selectdates, $type = 'all', PropertyTypes $propertytypes, $date_start = '', $date_end = '', $sleeps = '')
    {

        $date_start = date('Y-m-d', strtotime($date_start));
        $date_end   = date('Y-m-d', strtotime($date_end));
        $selectdates->saveDatesSearchedToSession($date_start, $date_end);
        
        if($type=='all'){

                $properties_vacation = Properties::where('is_active', 1)
                ->where('is_vacation', 1)
                ->where('sleeps', '>=', $sleeps)
                ->with(array(
                    'calendar' => function($query) use ($date_start, $date_end)
                    {
                        $query->whereBetween('date',[$date_start,$date_end])->get();
                    }
                ))->orderBy('display_order','asc')->get();

        }else{

                $category_id = $propertytypes->getPropertyTypeID($type);
                $properties_vacation = Properties::where('is_active', 1)
                ->where('is_vacation', 1)
                ->where('sleeps', '>=', $sleeps)
                ->where('category_id', $category_id)
                ->with(array(
                    'calendar' => function($query) use ($date_start, $date_end)
                    {
                        $query->whereBetween('date',[$date_start,$date_end])->get();
                    }
                ))->orderBy('display_order','asc')->get();
        }  


        $properties          = array();
        $nights            = intval((strtotime($date_end) - strtotime($date_start)) / 86400);
        foreach ($properties_vacation as $property) {
            if (count($property->calendar) == 0) {
                //Available - Property has no dates booked on the calendar 
                $property->price    = $selectdates->calculateLodgingPrice($property->slug, $date_start, $date_end);
                if($property->minimum_stay_nights<=$nights){/*upgrade - 12/10/2016 - minimum_nights*/
                    array_push($properties, $property);
                }

            } //count($property->calendar) == 0
        } //$properties_vacation as $property
        $settings          = Settings::find(1);
        $menu_top          = $nav->getHTMLNavigation();
        $categories        = Categories::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $locations         = ModelLocations::where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $footer_pages      = Pages::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        $footer_properties = Properties::where('is_active', 1)->where('is_featured', 1)->orderBy('display_order', 'asc')->get();
        return view('properties.search-rental')->with('settings', $settings)->with('menu_top', $menu_top)
        ->with('categories', $categories)->with('locations', $locations)->with('selectedtype', $type)
        ->with('date_start', date('m/d/Y', strtotime($date_start)))
        ->with('date_end', date('m/d/Y', strtotime($date_end)))
        ->with('nights', $nights)->with('sleeps', $sleeps)->with('properties', $properties)
        ->with('footer_pages', $footer_pages)->with('footer_properties', $footer_properties);
    }
}
