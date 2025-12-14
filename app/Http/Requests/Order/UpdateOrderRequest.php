<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow all users or add auth logic
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'table_id' => 'sometimes|nullable|exists:tables,id',
            'status' => 'sometimes|in:pending,processing,completed,cancelled',
            'payment_status' => 'sometimes|in:pending,paid,failed',
            'items' => 'sometimes|array|min:1',
            'items.*.menu_item_id' => 'required_with:items|exists:menu_items,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
        ];
    }
}
