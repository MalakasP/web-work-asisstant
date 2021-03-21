<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorktimeRequest extends FormRequest
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
            'end_time' => ['required', 'date'],
            'duration' => ['date_format:H:i'],
            'user_id' => ['required', 'integer', 'numeric'],
            'team_id' => ['nullable', 'integer', 'numeric']
        ];
    }
}
