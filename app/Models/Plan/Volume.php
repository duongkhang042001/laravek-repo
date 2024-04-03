<?php

namespace App\Models\Plan;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    use HasRoles;

    protected $table = 'v3_volume_pricings';

    protected $fillable = [
        'plan_id',
        'min_qty',
        'max_qty',
        'price_per_unit'
    ];

    const UPDATED_AT = null;

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
