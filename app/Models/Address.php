<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'description',
        'district',
        'reference',
        'receiver',
        'receiver_info',
        'default',
    ];

    protected $casts = [
        'receiver_info' => 'array',
        'default' => 'boolean',
    ];
}
