<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RsvpRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}
	
	public function rules(): array
	{
		return [
			'meetup_id' => ['required', Rule::exists('meetups', 'id')],
			'full_name' => ['required'],
			'email' => ['required', 'email', 'max:254'],
			'interests' => ['required', 'array'],
			'interests.*' => ['required', 'string'],
		];
	}
}
