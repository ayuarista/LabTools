<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Item extends Model
{
    protected $fillable = [
        'name',
        'description',
        'stock',
        'category_id',
    ];

    public function image(): MorphOne
    {
        return $this->morphOne(File::class, 'relation');
    }

    public function loan()
    {
        return $this->belongsTo(LoanItem::class);
    }

    public function return(): HasMany
    {
        return $this->hasMany(ReturnItem::class);
    }
}
