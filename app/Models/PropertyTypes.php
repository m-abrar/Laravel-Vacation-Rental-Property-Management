<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyTypes extends Model {

	protected $table = 'emt_property_types';

	public function properties()
	{
		return $this->hasMany('App\Models\Properties','category_id');
	}


}
