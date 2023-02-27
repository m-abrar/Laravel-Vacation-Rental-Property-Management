<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Properties extends Model {

	protected $table = 'emt_properties';

	public function classez()
	{
		return $this->hasMany('App\Models\PropertiesClasses','property_id');
	}

	public function images()
	{
		return $this->hasMany('App\Models\PropertiesImages','property_id');
	}

	public function amenities()
	{
		return $this->hasMany('App\Models\PropertiesAmenities','property_id');
	}

	public function location()
	{
		return $this->belongsTo('App\Models\ModelLocations','state_id','id');
	}

	public function category()
	{
		return $this->belongsTo('App\Models\PropertyTypes','category_id','id');
	}

	public function owner()
	{
		return $this->belongsTo('App\Models\User','user_id','id');
	}

	public function housekeeper()
	{
		return $this->hasOne('App\Models\Facilitators','id','housekeeper_id');
	}

	public function vendor()
	{
		return $this->hasOne('App\Models\Facilitators','id','vendor_id');
	}

	public function calendar()
	{
		return $this->hasMany('App\Models\Calendar','property_id');
	}

	public function reservations()
	{
		return $this->hasMany('App\Models\Reservations','property_id');
	}


}
