<?php

namespace App\Models\Auth_SuperVisor;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\MenuCategoryFactory::new();
    }

    //
    protected $fillable = [
        'name',
        'branch_id',
    ];
     public function items()
    {
        return $this->hasMany(MenuItem::class);
    }
}
