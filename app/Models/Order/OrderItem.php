<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use App\Models\Auth_SuperVisor\MenuItem;
use App\Models\Auth_SuperVisor\MenuItemAddon;

class OrderItem extends Model
{
    //
    protected $fillable = ['order_id', 'menu_item_id', 'quantity', 'price'];

    public function order() {
        return $this->belongsTo(Order::class);
    }
    public function product() {
        return $this->belongsTo(MenuItem::class, 'menu_item_id');
    }
    public function addons()
    {
        return $this->hasMany(OrderItemAddon::class);
    }


}
