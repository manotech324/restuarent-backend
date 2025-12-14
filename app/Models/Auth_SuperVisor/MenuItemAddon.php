<?php

namespace App\Models\Auth_SuperVisor;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItemAddon extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\MenuItemAddonFactory::new();
    }

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
