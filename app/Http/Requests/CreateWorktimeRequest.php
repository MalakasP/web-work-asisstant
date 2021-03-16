<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorktimeRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'end_time' => ['date_format:H:i'],
            'duration' => ['date_format:H:i'],
            'user_id' => ['required', 'integer', 'numeric'],
            'team_id' => ['required', 'integer', 'nullable', 'numeric']
        ];
    }
}
