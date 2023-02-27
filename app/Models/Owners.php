<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owners extends Model {

	protected $table = 'users';

	public function properties()
	{
		return $this->hasMany('App\Models\Properties','user_id','id');
	}

}
