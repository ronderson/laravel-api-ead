<?php

namespace App\Http\Requests;

use App\Models\Support;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreSupport extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Support $support): array
    {
        return [
            'lesson' => [
                'required',
                'exists:lessons,id'
            ],
            'status' => [
                'required',
                Rule::in(array_keys($support->statusOptions))
            ],
            'description' => [
                'required',
                'min:3',
                'max:10000'
            ],
        ];
    }
}
