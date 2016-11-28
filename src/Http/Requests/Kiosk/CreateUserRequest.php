<?php

namespace Laravel\Spark\Http\Requests\Kiosk;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Spark\Contracts\Http\Requests\Kiosk\CreateUserRequest as Contract;

class CreateUserRequest extends FormRequest implements Contract
{
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
     * Get the validation rules for the request.
     *
     * @return \Illuminate\Validation\Validator
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|max:255|unique:users'
        ];
    }
}
