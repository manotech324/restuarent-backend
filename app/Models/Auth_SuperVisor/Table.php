<?php

namespace App\Models\Auth_SuperVisor;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\TableFactory::new();
    }

    //
      protected $fillable = ['name', 'branch_id'];

      public function branch() {
          return $this->belongsTo(\App\Models\Admin\Branch::class);
      }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
