<?php

namespace App\Models\Brandname;

use App\Models\Auth\User;
use App\Abstracts\Models\Model;

class BrandnameConfig extends Model
{
    protected $table = 'v3_brandname_configs';

    protected $fillable = [
        'provider',
        'telco',
        'country_code',
        'region_code',
        'is_unicode',
        'is_encrypted'
    ];
    public $timestamps = false;

    public function brandname()
    {
        return $this->belongsTo(Brandname::class, 'brandname_id');
    }
}
