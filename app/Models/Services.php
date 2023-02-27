<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model {

	protected $table = 'emt_services';

	public function added()
	{
		return $this->hasMany('App\Models\ReservationsServices','service_id');
	}

}
