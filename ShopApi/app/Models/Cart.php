<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'carts';
    protected $fillable = [
        'user_id',
    ];

    protected function casts(): array
    {
        return ['created_at' => 'datetime:l, Y-m-d H:i'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->WhereNull('carts.ordered_at')->withPivot('quantity')->withTimestamps();
    }
    public function productAll(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }
}


