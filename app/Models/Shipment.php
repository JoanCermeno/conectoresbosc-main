<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Driver;
use App\Enums\ShipmentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'driver_id',
        'status',
        'refunded_at',
        'delivered_at',
    ];

    public $casts = [
        'status' => ShipmentStatus::class,
        'refunded_at' => 'datetime',
        'delivered_at'=> 'datetime',

    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
