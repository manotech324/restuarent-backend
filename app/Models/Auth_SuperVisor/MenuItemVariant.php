<?php

namespace App\Models\Auth_SuperVisor;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItemVariant extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\MenuItemVariantFactory::new();
    }

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
