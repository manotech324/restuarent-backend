<?php

namespace App\Models\Auth_SuperVisor;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
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
