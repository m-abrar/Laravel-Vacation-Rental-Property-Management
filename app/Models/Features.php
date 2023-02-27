<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Features extends Model {

	protected $table = 'emt_features';

	public function added()
	{
		return $this->hasMany('App\Models\PropertiesFeatures','feature_id');
	}

}
