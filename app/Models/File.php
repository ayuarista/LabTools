<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    protected $fillable = [
        'file_name',
        'file_type',
        'file_path',
    ];

    public function relation(): MorphTo
    {
        return $this->morphTo();
    }
}
