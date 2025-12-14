<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\BranchFactory::new();
    }

    //
        protected $fillable = ['name', 'location', 'phone'];

}
