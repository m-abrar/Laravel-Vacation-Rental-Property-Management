<?php
namespace App\Http\Controllers\Owner\Properties;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertiesFormRequest;
use App\Http\Controllers\Owner\OwnerController as Panel;
use Illuminate\Http\Request;
class PropertiesController extends Controller
{
    //List of all properties with actions for edit/add/delete.
    public function index(Panel $panel)
    {
        $settings      = Settings::find(1);
        $user          = \Auth::user();
        $notifications = $panel->notifications();
        $properties    = Properties::where('user_id', \Auth::user()->id)->orderBy('display_order', 'asc')->get();
        $js            = "$('#treeview-properties').addClass('active');\n";
        return view('owner.properties.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('properties', $properties)->with('js', $js);
    }
    //Form for adding a new property in our database table.
    public function create()
    {
        $categories   = PropertyTypes::orderBy('display_order', 'asc')->get();
        $classes      = PropertyClasses::orderBy('display_order', 'asc')->get();
        $states       = Locations::where('type', 'state')->orderBy('is_active', 1)->orderBy('display_order', 'asc')->get();
        $housekeepers = Facilitators::where('role', 'housekeeper')->where('is_active', '1')->orderBy('firstname', 'asc')->get();
        $vendors      = Facilitators::where('role', 'vendor')->where('is_active', '1')->orderBy('firstname', 'asc')->get();
        $rates        = Seasons::where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $amenities    = Amenities::where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $features     = Features::where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $settings     = Settings::find(1);
        return view('owner.properties.create')->with('settings', $settings)->with('categories', $categories)->with('classes', $classes)->with('states', $states)->with('housekeepers', $housekeepers)->with('vendors', $vendors)->with('rates', $rates)->with('amenities', $amenities)->with('features', $features);
    }
    //Inserts the form into database table of properties and other tables like, features, amenties, rates, images...
    public function store(PropertiesFormRequest $request)
    {
        $property        = new Properties();
        $property->title = $request->input('title');
        $property->slug  = $slug = str_slug($property->title);
        $property->code  = $code = $request->input('code');
        $duplicate       = Properties::where('slug', $slug)->first();
        if ($duplicate)
            return redirect('/admin/properties/create')->withErrors('Slug must not be already used!')->withInput();
        $duplicate = Properties::where('code', $code)->first();
        if ($duplicate)
            return redirect('/admin/properties/create')->withErrors('Code/SKU already exists!')->withInput();
        //The common part of both insert/update code has been put in a single function place called save().
        //Returns success of success, edit, insert id if any.
        list($success, $error, $id) = PropertiesController::save($request, $property);
        return redirect('/admin/properties/edit/' . $id)->withMessage($success)->withErrors($error);
    }
    //When you want to enter changes to a specific property
    //Load the edit form
    public function edit($id)
    {
        $property     = Properties::where('id', $id)->first();


        $images       = PropertiesImages::where('property_id', $property->id)->get(); //future: is_active
        $categories   = PropertyTypes::orderBy('display_order', 'asc')->get();
        $classes      = PropertyClasses::orderBy('display_order', 'asc')->get();
        $states       = Locations::where('type', 'state')->where('is_active', 1)->orderBy('display_order', 'asc')->get();
        $housekeepers = Facilitators::where('role', 'housekeeper')->where('is_active', '1')->orderBy('firstname', 'asc')->get();
        $vendors      = Facilitators::where('role', 'vendor')->where('is_active', '1')->orderBy('firstname', 'asc')->get();
        $seasons      = Seasons::where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $rates        = array();
        foreach ($seasons as $season) {
            $Prates = PropertiesRates::where('property_id', $id)->where('season_id', $season->id)->first();
            $array  = (object) array(
                'id' => $season->id,
                'title' => $season->title,
                'season_start_month' => $season->season_start_month,
                'season_start_day' => $season->season_start_day,
                'season_end_month' => $season->season_end_month,
                'season_end_day' => $season->season_end_day,
                'minimum_stay_nights' => @$Prates->minimum_stay_nights,
                'final_payment_days' => @$Prates->final_payment_days,
                'price_daily' => @$Prates->price_daily,
                'is_price_daily' => @$Prates->is_price_daily,
                'price_weekly' => @$Prates->price_weekly,
                'is_price_weekly' => @$Prates->is_price_weekly,
                'price_two_weekly' => @$Prates->price_two_weekly,
                'is_price_two_weekly' => @$Prates->is_price_two_weekly,
                'price_monthly' => @$Prates->price_monthly,
                'is_price_monthly' => @$Prates->is_price_monthly
            );
            array_push($rates, $array);
        } //$seasons as $season
        $amenities       = Amenities::where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $amenities_final = array();
        foreach ($amenities as $amenity) {
            $PAmenity = PropertiesAmenities::where('property_id', $id)->where('amenity_id', $amenity->id)->first();
            $array    = (object) array(
                'id' => $amenity->id,
                'title' => $amenity->title,
                'value' => @$PAmenity->value
            );
            array_push($amenities_final, $array);
        } //$amenities as $amenity
        $features       = Features::where('is_active', '1')->orderBy('display_order', 'asc')->get();
        $features_final = array();
        foreach ($features as $feature) {
            $PFeature = PropertiesFeatures::where('property_id', $id)->where('feature_id', $feature->id)->first();
            $array    = (object) array(
                'id' => $feature->id,
                'title' => $feature->title,
                'value' => @$PFeature->value
            );
            array_push($features_final, $array);
        } //$features as $feature
        return view('owner.properties.edit')->with('property', $property)
        ->with('edit', true)->with('images', $images)
        ->with('categories', $categories)->with('states', $states)
        ->with('classes', $classes)
        ->with('housekeepers', $housekeepers)->with('vendors', $vendors)
        ->with('rates', $rates)
        ->with('amenities', $amenities_final)->with('features', $features_final);
    }
    //The common part of both insert/update code has been put in a single function place called save().
    public function save($request, $property)
    {
        $property->category_id        = $request->input('category');


        $property->bedrooms           = $request->input('bedrooms');
        $property->bathrooms          = $request->input('bathrooms');
        $property->sleeps             = $request->input('sleeps');
        $property->garages            = $request->input('garages');
        $property->address            = $request->input('address');
        $property->city               = $request->input('city');
        $property->state_id           = $request->input('state');
        $property->zip                = $request->input('zip');
        $property->latitude           = $request->input('latitude');
        $property->longitude          = $request->input('longitude');
        $property->display_order      = $request->input('display_order');
        $property->is_active          = $request->has('is_active') ? '1' : '0';
        $property->is_featured        = $request->has('is_featured') ? '1' : '0';
        $property->is_new             = $request->has('is_new') ? '1' : '0';
        $property->is_sale            = $request->has('is_sale') ? '1' : '0';
        $property->is_long_term       = $request->has('is_long_term') ? '1' : '0';
        $property->is_vacation        = $request->has('is_vacation') ? '1' : '0';
        $property->is_calendar        = $request->has('is_calendar') ? '1' : '0';
        $property->is_rates           = $request->has('is_rates') ? '1' : '0';
        $property->summary            = $request->input('summary');
        $property->notes_admin        = $request->input('notes_admin');
        $property->description        = $request->input('description');
        $property->reviews            = $request->input('reviews');
        $property->is_cleaning_fee    = $request->has('is_cleaning_fee') ? 1 : 0;
        $property->cleaning_fee_value = $request->input('cleaning_fee_value');
        $property->is_commission      = $request->has('is_commission') ? 1 : 0;
        $property->commission_value   = $request->input('commission_value');
        $property->is_sales_tax       = $request->has('is_sales_tax') ? 1 : 0;
        $property->sales_tax_value    = $request->input('sales_tax_value');
        $property->is_lodger_tax      = $request->has('is_lodger_tax') ? 1 : 0;
        $property->lodger_tax_value   = $request->input('lodger_tax_value');
        $property->housekeeper_id     = $request->input('housekeeper_id');
        $property->vendor_id          = $request->input('vendor_id');
        $user_session  = \Auth::user();
        $property->user_id           = $user_session->id;

        $property->save();
        $property_id = $property->id;

        $propertyClasses = PropertiesClasses::where('property_id', $property->id);
        $propertyClasses->delete();
        if(null!==$request->input('classes')){
        foreach ($request->input('classes') as $class) {
            $propertyClass              = new PropertiesClasses();
            $propertyClass->property_id = $property->id;
            $propertyClass->class_id    = $class;
            $propertyClass->save();
        }
        }
        @$success .= 'Property has been successfully saved.<br/>';
        
        if (!empty($property_id)) {
            $fileprefix = 'property-';
            $filepath   = 'pictures/';
            for ($i = 1; $i <= $request->input('images_total'); $i++) {
                if ($request->has('image_delete_' . $i)) {
                    $PImage = PropertiesImages::find($request->get('image_delete_' . $i));
                    $PImage->delete();
                } //$request->has('image_delete_' . $i)
                if ($request->get('image_db_id_' . $i) != 'NA') {
                    $propertyImage = PropertiesImages::find($request->get('image_db_id_' . $i));
                } //$request->get('image_db_id_' . $i) != 'NA'
                else {
                    $propertyImage = new PropertiesImages();
                }
                $filename = str_replace('tmp/', '', $request->input('tmp_img_path_' . $i));
                if (is_file('tmp/' . $filename)) {
                    \File::move('tmp/' . $filename, $filepath . $fileprefix . $filename);
                    $propertyImage->property_id = $property_id;
                    $propertyImage->image       = $filepath . $fileprefix . $filename;
                    $propertyImage->is_active   = '1';
                    $propertyImage->save();
                    @$success .= 'Image saved: ' . $propertyImage->image . ' <br/>';
                } //is_file('tmp/' . $filename)
            } //$i = 1; $i <= $request->input('images_total'); $i++
            $property->minimum_stay_nights = $request->get('minimum_stay_nights');
            $property->final_payment_days  = $request->get('final_payment_days');
            $property->price_daily         = $request->get('price_daily');
            $property->is_price_daily      = $request->has('is_price_daily') ? '1' : '0';
            $property->price_weekly        = $request->get('price_weekly');
            $property->is_price_weekly     = $request->has('is_price_weekly') ? '1' : '0';
            $property->price_two_weekly    = $request->get('price_two_weekly');
            $property->is_price_two_weekly = $request->has('is_price_two_weekly') ? '1' : '0';
            $property->price_monthly       = $request->get('price_monthly');
            $property->is_price_monthly    = $request->has('is_price_monthly') ? '1' : '0';
            $property->save();
            @$success .= 'Regular prices saved.<br/>';
            $PRates = PropertiesRates::where('property_id', $property_id);
            $PRates->delete();
            $seasons = Seasons::where('is_active', '1')->orderBy('display_order', 'asc')->get();
            foreach ($seasons as $season) {
                $month   = $season->season_start_month;
                $day     = $season->season_start_day;
                $endloop = $season->season_end_month . '-' . $season->season_end_day;
                $date    = '';
                while (1 < 2) { //unlimited loop
                    if ($date == $endloop) {
                        break;
                    } //$date == $endloop
                    while ($day <= 31) {
                        $date                              = $month . '-' . $day;
                        $propertyRate                      = new PropertiesRates();
                        $propertyRate->property_id         = $property_id;
                        $propertyRate->season_id           = $season->id;
                        $propertyRate->date                = $date;
                        $propertyRate->minimum_stay_nights = $request->get('minimum_stay_nights_' . $season->id);
                        $propertyRate->final_payment_days  = $request->get('final_payment_days_' . $season->id);
                        $propertyRate->price_daily         = $request->get('price_daily_' . $season->id);
                        $propertyRate->is_price_daily      = $request->has('is_price_daily_' . $season->id) ? '1' : '0';
                        $propertyRate->price_weekly        = $request->get('price_weekly_' . $season->id);
                        $propertyRate->is_price_weekly     = $request->has('is_price_weekly_' . $season->id) ? '1' : '0';
                        $propertyRate->price_two_weekly    = $request->get('price_two_weekly_' . $season->id);
                        $propertyRate->is_price_two_weekly = $request->has('is_price_two_weekly_' . $season->id) ? '1' : '0';
                        $propertyRate->price_monthly       = $request->get('price_monthly_' . $season->id);
                        $propertyRate->is_price_monthly    = $request->has('is_price_monthly_' . $season->id) ? '1' : '0';
                        $propertyRate->save();
                        if ($date == $endloop) {
                            break;
                        } //$date == $endloop
                        $day++;
                    } //$day <= 31
                    $day = 1;
                    if ($month == '12')
                        $month = 1;
                    else
                        $month++;
                } //1 < 2
                unset($date);
                //@$success .= $season->title.' prices saved.<br/>';
            } //$seasons as $season
            @$success .= 'Prices saved.<br/>';
            $PFeatures = PropertiesFeatures::where('property_id', $property_id);
            $PFeatures->delete();
            $features = Features::where('is_active', '1')->orderBy('display_order', 'asc')->get();
            foreach ($features as $feature) {
                $propertyFeature              = new PropertiesFeatures();
                $propertyFeature->property_id = $property_id;
                $propertyFeature->feature_id  = $feature->id;
                $propertyFeature->value       = $request->get('feature_value_' . $feature->id);
                $propertyFeature->save();
            } //$features as $feature
            @$success .= 'Features have been added.<br/>';
            $PAmenities = PropertiesAmenities::where('property_id', $property_id);
            $PAmenities->delete();
            $amenities = Amenities::where('is_active', '1')->orderBy('display_order', 'asc')->get();
            foreach ($amenities as $amenity) {
                $propertyAmenity              = new PropertiesAmenities();
                $propertyAmenity->property_id = $property_id;
                $propertyAmenity->amenity_id  = $amenity->id;
                if ($request->has('amenity_value_' . $amenity->id)) {
                    $propertyAmenity->value = $request->get('amenity_value_' . $amenity->id);
                } //$request->has('amenity_value_' . $amenity->id)
                else {
                    $propertyAmenity->value = 'No';
                }
                $propertyAmenity->save();
            } //$amenities as $amenity
            @$success .= 'Amenities have been added.<br/>';
        } //!empty($property_id)
        return array(
            @$success,
            @$error,
            $property_id
        );
    }
    //Update the database when you submit the edit form
    public function update(PropertiesFormRequest $request)
    {
        $id              = $request->input('id');
        $property        = Properties::find($id);

        $property->title = $request->input('title');
        $property->slug  = $slug = str_slug($property->title);
        $property->code  = $code = $request->input('code');
        $duplicate       = Properties::where('slug', $slug)->where('id', '!=', $id)->first();
        if ($duplicate)
            return redirect('/admin/properties/edit/' . $id)->withErrors('Slug must not be already used!')->withInput();
        $duplicate = Properties::where('code', $code)->where('id', '!=', $id)->first();
        if ($duplicate)
            return redirect('/admin/properties/edit/' . $id)->withErrors('Code/SKU already exists!')->withInput();
        list($success, $error, $id) = PropertiesController::save($request, $property);
        return redirect('/admin/properties/edit/' . $id)->withMessage($success)->withErrors($error);
    }
    //Delete a property and its sub items
    public function destroy(Request $request, $id)
    {
        $PImage = PropertiesImages::where('property_id', $id);
        $PImage->delete();
        $PRates = PropertiesRates::where('property_id', $id);
        $PRates->delete();
        $PFeatures = PropertiesFeatures::where('property_id', $id);
        $PFeatures->delete();
        $PAmenities = PropertiesAmenities::where('property_id', $id);
        $PAmenities->delete();
        $property = Properties::find($id);
        $property->delete();
        $success = 'Property deleted<br/>';
        return redirect('/admin/properties')->withMessage($success);
    }
}
