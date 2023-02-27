<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertiesClasses extends Model {

	protected $table = 'emt_properties_classes';

	public function theclass()
	{
		return $this->belongsTo('App\Models\PropertyClasses','class_id');
	}

	public function property()
	{
		return $this->belongsTo('App\Models\Properties','property_id');
	}

}
