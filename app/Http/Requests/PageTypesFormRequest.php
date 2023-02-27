<?php namespace App\Http\Requests;


class PageTypesFormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		//return true;
		//abrar

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
			//'body' => 'required',
		];
	}	
}
