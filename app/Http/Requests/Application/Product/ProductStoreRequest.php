<?php

namespace App\Http\Requests\Application\Product;

use App\Enums\ProductsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ProductStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:500'],
            'description' => ['required', 'string', 'min:3', 'max:500'],
            'type' => ['required', 'int', 'min:1', new Enum(ProductsEnum::class) ],
            'cost_price' => ['required', 'numeric', 'gt:0', 'min:0'],
            'price' => ['required', 'numeric', 'gt:0', 'min:0'],
        ];
    }
}
