<?php

namespace App\Models\File;

use App\Abstracts\Models\Model;

class Import extends Model
{
    protected $table = 'v3_file_imports';

    protected $fillable = [
        'name',
        'path',
        'path_hash',
        'size',
        'data'
    ];

    public function getLinkUrl()
    {
        return config('services.static.url') . '/' . $this->path;
    }
}
