<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use App\Models\Auth_SuperVisor\Table;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'table_id',
        'total_price',
        'status',
        'payment_status',
        'branch_id',
    ];

    // Order → has many OrderItems
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Order → belongs to Table
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\Admin\Branch::class);
    }


}
