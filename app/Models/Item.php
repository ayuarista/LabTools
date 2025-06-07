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
        'quantity',
    ];

    public function image(): MorphOne
    {
        return $this->morphOne(File::class, 'relation');
    }

    public function loan()
    {
        return $this->hasMany(LoanItem::class);
    }

    public function return(): HasMany
    {
        return $this->hasMany(ReturnItem::class);
    }
}
