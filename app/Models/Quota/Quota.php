<?php

namespace App\Models\Quota;

use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    protected $table = 'v3_quota';

    protected $fillable = ['quotas_limit'];

    const UPDATED_AT = null;
}
