<?php namespace App\Http\Requests;


class FrontendReservations extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'firstname' => array('Regex:/^[A-Za-z0-9 ]+$/','required'),
			'lastname' => array('Regex:/^[A-Za-z0-9 ]+$/','required'),
			'email' => 'required|email',
			'phone' => array('Regex:/^[0-9 ]+$/','required'),
			'city' => array('Regex:/^[A-Za-z ]+$/','required'),
			'state' => array('Regex:/^[0-9 ]+$/','required'),
			//'zip' => array('Regex:/^[0-9 ]+$/','required'),
			'zip' => array('Regex:/^[A-Za-z0-9 ]+$/','required'),
			'email' => 'required|email',
		];
	}	
}
