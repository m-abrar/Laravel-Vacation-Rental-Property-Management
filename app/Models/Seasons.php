<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seasons extends Model {

	protected $table = 'emt_seasons';

	public function added()
	{
		return $this->hasMany('App\Models\PropertiesRates','season_id');
	}


	public function scopeRatesByPropertyXXX($query, $property_id)
    {
	
		return \DB::table('emt_seasons')

			 ->leftJoin('emt_properties_rates', 'emt_seasons.id', '=', 'emt_properties_rates.season_id')
			 ->where('emt_seasons.is_active', 1)
			 ->where('emt_properties_rates.property_id', $property_id)
			 ->orderBy('emt_seasons.display_order', 'asc')
			 ->groupBy('emt_seasons.id')
			 ->get();

    }

}
