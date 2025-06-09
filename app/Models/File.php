<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    protected $fillable = [
        'file_name',
        'file_type',
        'file_path',
        'relation_id',
        'relation_type',
    ];

    public function relation(): MorphTo
    {
        return $this->morphTo();
    }

    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }

        return secure_asset('null');
    }

    public static function uploadFile(UploadedFile $file, Model $model, $relation, $directory)
    {
        $filePath = $file->store($directory, 'public');
        $fileName = $file->getClientOriginalName();
        $fileType = $file->getMimeType();

        return $model->$relation()->create([
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_path' => $filePath,
        ]);
    }
}
