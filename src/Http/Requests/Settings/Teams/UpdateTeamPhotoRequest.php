<?php

namespace Laravel\Spark\Http\Requests\Settings\Teams;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamPhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->ownsTeam($this->route('team'));
    }

    /**
     * Get the validation rules for the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'photo' => 'required|image|max:4000'
        ];
    }
}
