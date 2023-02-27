<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenities extends Model {

	protected $table = 'emt_amenities';

	public function added()
	{
		return $this->hasMany('App\Models\PropertiesAmenities','amenity_id');
	}
}
