<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequestRequest extends FormRequest
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
            'date_from' => ['required', 'date', 'after:yesterday'],
            'date_to' => ['required', 'date', 'after:date_from'],
            'description' => ['required', 'string', 'max:191'],
            'type' => ['required', 'string', 'max:191'],
            'requester_id' => ['required', 'integer', 'numeric'],
            'responser_id' => ['required', 'integer', 'numeric'],
            'team_id' => ['required', 'integer', 'numeric']
        ];
    }
}
