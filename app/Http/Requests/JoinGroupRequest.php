<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JoinGroupRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}
	
	public function rules(): array
	{
		return [
			'group_id' => ['required', 'int', 'exists:groups,id'],
			'name' => ['required', 'string'],
			'email' => ['required', 'email'],
		];
	}
}
