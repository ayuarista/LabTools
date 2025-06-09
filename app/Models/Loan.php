<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    protected $fillable =
    [
        'user_id',
        'loan_date',
        'start_at',
        'return_at',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loanItems()
    {
        return $this->hasMany(LoanItem::class);
    }

    public function returnItems(): HasMany
    {
        return $this->hasMany(ReturnItem::class);
    }
}
