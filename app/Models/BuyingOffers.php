<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyingOffers extends Model {

	protected $table = 'emt_buying_offers';

	public function property()
	{
		return $this->belongsTo('App\Models\Properties','property_id','id');
	}
}
