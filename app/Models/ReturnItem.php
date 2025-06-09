<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    protected $fillable = [
        'loan_id',
        'item_id',
        'return_date',
        'conditional',
        'penalty',
        'note',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
