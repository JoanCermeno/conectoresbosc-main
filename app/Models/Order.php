<?php

namespace App\Models;

use App\Models\Shipment;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [
        'status'
    ];

    protected $casts = [
        'content' => 'array',
        'address' => 'array',
        'status' => OrderStatus::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
