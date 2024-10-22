<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
    ];
    public function cart(): BelongsToMany
    {
        return  $this->belongsToMany(Cart::class)->withPivot('quantity')->withTimestamps();
    }

}

