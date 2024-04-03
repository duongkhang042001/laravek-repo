<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'v3_settings';

    public $timestamps = false;

    protected $guarded = [];
}
