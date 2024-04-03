<?php

namespace App\Models\Plan;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasRoles;

    protected $table = 'v3_plans';

    protected $fillable = [
        'name',
        'partner_id',
        'provider',
        'telco',
        'sms_type',
        'region_code',
        'sms_usage_count'
    ];

    public function volumes()
    {
        return $this->hasMany(Volume::class);
    }
}
