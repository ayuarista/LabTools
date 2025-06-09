<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class StudentProfile extends Model
{
    protected $fillable =
    [
        'name',
        'nis',
        'kelas',
        'jurusan',
    ];

    public function avatar(): MorphOne
    {
        return $this->morphOne(File::class, 'relation');
    }
}
