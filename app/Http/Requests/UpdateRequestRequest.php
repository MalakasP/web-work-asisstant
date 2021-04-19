<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestRequest extends FormRequest
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
            'date_from' => ['date', 'after:yesterday'],
            'date_to' => ['date', 'after:date_from'],
            'description' => ['string', 'max:191'],
            'type' => ['string', 'max:191'],
            'is_confirmed' => ['boolean'],
            'confirmed_at' => ['date'],
            'requester_id' => ['integer', 'numeric'],
            'responser_id' => ['integer', 'numeric']
        ];
    }
}
