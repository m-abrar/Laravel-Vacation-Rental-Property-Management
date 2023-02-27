<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationsServices extends Model
{

	protected $table = 'emt_reservations_services';
	public function reservation()
	{
		return $this->belongsTo('App\Models\Reservations','reservation_id');
	}
	public function service()
	{
		return $this->belongsTo('App\Models\Services','service_id');
	}
}
