<?php

namespace App\Models\Auth_SuperVisor;
use App\Models\Admin\Branch;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\MenuItemFactory::new();
    }

    //
    protected $fillable = [
        'category_id',
        'branch_id',
        'menu_item_id',
        'name',
        'price',
        'image',
        'description',
        'is_available'
    ];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
    public function variants()
{
    return $this->hasMany(MenuItemVariant::class, 'menu_item_id');
}

public function addons()
{
    return $this->hasMany(MenuItemAddon::class, 'menu_item_id');
}
public function category()
{
    return $this->belongsTo(MenuCategory::class, 'category_id');
}

public function branch()
{
    return $this->belongsTo(Branch::class, 'branch_id');
}


}
