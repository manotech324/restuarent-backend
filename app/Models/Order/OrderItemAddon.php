<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Auth_SuperVisor\MenuItemAddon;

class OrderItemAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'menu_item_addon_id',
        'quantity',
        'price',
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function menuItemAddon()
    {
        return $this->belongsTo(MenuItemAddon::class, 'menu_item_addon_id');
    }
}
