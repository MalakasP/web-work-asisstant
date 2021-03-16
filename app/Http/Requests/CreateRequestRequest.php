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
            'date_from' => ['required', 'date', 'after:start_date'],
            'date_to' => ['required', 'date', 'after:start_date'],
            'description' => ['required', 'string', 'max:191'],
            'type' => ['required', 'string', 'max:191'],
            'is_confirmed' => ['boolean'],
            'requester_id' => ['required', 'integer', 'numeric'],
            'responser_id' => ['required', 'integer', 'numeric']
        ];
    }
}
