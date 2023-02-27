<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertiesAmenities extends Model {

	protected $table = 'emt_properties_amenities';

	public function property()
	{
		return $this->belongsTo('App\Models\Properties','property_id');
	}

	public function amenity()
	{
		return $this->belongsTo('App\Models\Amenities','amenity_id');
	}

}
