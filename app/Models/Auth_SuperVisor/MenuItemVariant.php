<?php

namespace App\Models\Auth_SuperVisor;

use Illuminate\Database\Eloquent\Model;

class MenuItemVariant extends Model
{
     protected $fillable = [
        'menu_item_id',
        'name',
        'price',
        'is_available'
    ];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
