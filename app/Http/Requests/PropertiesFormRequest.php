<?php namespace App\Http\Requests;


class PropertiesFormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		
		if($this->user()->can_post())
		{
			return true;
		}
		return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'title' => array('Regex:/^[A-Za-z0-9 ]+$/'),
			'title' => 'required',
			'slug' => 'required',
			'code' => 'required',
			'category' => 'required',
			'bedrooms' => 'required',
			'bathrooms' => 'required',
			'sleeps' => 'required',
			'garages' => 'required',
			'address' => 'required',
			'city' => 'required',
			'state' => 'required',
			'zip' => 'required',
			'address' => 'required',
			'address' => 'required',

		];
	}	
}
