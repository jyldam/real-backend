<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class HousingCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:30|min:1',
            'disabled' => 'required|bool',
            'sort'     => 'required|int',
        ];
    }
}
