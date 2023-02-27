<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservations extends Model {

	protected $table = 'emt_reservations';

	public function property()
	{
		return $this->belongsTo('App\Models\Properties','property_id','id');
	}
	public function location()
	{
		return $this->belongsTo('App\Models\Locations','state_id','id');
	}

	public function transactions()
	{
		return $this->hasMany('App\Models\Transactions','reservation_id','id');
	}
	public function services()
	{
		return $this->hasMany('App\Models\ReservationsServices','reservation_id');
	}

}
