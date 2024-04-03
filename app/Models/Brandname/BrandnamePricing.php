<?php

namespace App\Models\Brandname;

use App\Models\Auth\User;
use App\Abstracts\Models\Model;

class BrandnamePricing extends Model
{
    protected $table = 'v3_brandname_pricings';

    protected $fillable = [
        'provider',
        'telco',
        'sms_type',
        'country',
        'country_code',
        'from_sms_qty',
        'to_sms_qty',
        'cost_per_sms',
        'price_per_sms'
    ];

    public function brandname()
    {
        return $this->belongsTo(Brandname::class, 'brandname_id');
    }
}
