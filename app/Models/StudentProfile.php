<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class StudentProfile extends Model
{
    protected $fillable =
    [
        'nis',
        'kelas',
        'jurusan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function avatar(): MorphOne
    {
        return $this->morphOne(File::class, 'relation');
    }
}
