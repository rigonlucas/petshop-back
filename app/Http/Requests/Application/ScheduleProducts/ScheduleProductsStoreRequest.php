<?php

namespace App\Http\Requests\Application\ScheduleProducts;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleProductsStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "product_id" => [
                'required',
                'integer',
            ],
            "quantity" => [
                'required',
                'integer',
                'gt:0'
            ],
            "price" => [
                'required',
                'numeric',
                'gt:-1'
            ],
            "discount" => [
                'nullable',
                'numeric',
                'gt:-1'
            ]
        ];
    }
}