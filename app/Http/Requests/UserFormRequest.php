<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use Auth;

class UserFormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{

		return true;

		/*if($this->user()->can_post())
		{
			return true;
		}
		return false;*/
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'firstname' => array('Regex:/^[A-Za-z0-9 ]+$/'),
			'firstname' => 'required',
			'lastname' => array('Regex:/^[A-Za-z0-9 ]+$/'),
			'lastname' => 'required',
			'username' => array('Regex:/^[A-Za-z0-9 ]+$/'),
			'username' => 'required',
			'email' => array('Regex:/^[A-Za-z0-9 ]+$/'),
			'email' => 'required|email',
			//'body' => 'required',
		];
	}	
}
