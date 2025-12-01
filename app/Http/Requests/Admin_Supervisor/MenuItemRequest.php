<?php

namespace App\Http\Requests\Admin_Supervisor;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:menu_categories,id',
            'branch_id' => 'nullable|exists:branches,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'is_available' => 'boolean',
            'variants' => 'required|array|min:1',
            'variants.*.name' => 'required|string|max:100',
            'variants.*.price' => 'required|numeric|min:0',
            'addons' => 'nullable|array',
            'addons.*.name' => 'required|string|max:255',
            'addons.*.price' => 'required|numeric|min:0'
        ];
    }
}
