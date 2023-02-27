<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model {

	protected $table = 'emt_transactions';

	public function reservation()
	{
		return $this->belongsTo('App\Models\Reservations','reservation_id','id');
	}	


}
