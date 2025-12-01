<?php

namespace App\Models\Auth_SuperVisor;

use Illuminate\Database\Eloquent\Model;

class MenuItemAddon extends Model
{
    //
    protected $fillable = [
        'category_id',
        'branch_id',
        'name',
        'price',
        'description',
        'image',
        'is_available'
    ];

    public function category()
    {
        return $this->belongsTo(MenuCategory::class);
    }

    public function variants()
    {
        return $this->hasMany(MenuItemVariant::class);
    }

    public function addons()
    {
        return $this->hasMany(MenuItemAddon::class);
    }
}
