<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'image_path',
        'price',
        'stock',
        'subcategory_id',
    ];

    public function scopeCustomOrder($query, $orderBy) {
        $query->when($orderBy == 1, function($query) {
            $query->orderBy('created_at', 'desc');
        })
        ->when($orderBy == 2, function($query) {
            $query->orderBy('price', 'desc');
        })
        ->when($orderBy == 3, function($query) {
            $query->orderBy('price', 'asc');
        });
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::url($this->image_path), 
           
        );
    }


    // Relacion uno a muchos inversa
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    // Relacion uno a muchos
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
    // Relacion muchos a muchos
    public function options() {
        return $this->belongsToMany(Option::class)
            ->using(OptionProduct::class)
            ->withPivot('features')
            ->withTimestamps();
    }
}
