<?php

namespace App\Models\Brandname;

use App\Models\Auth\User;
use App\Models\Core\Partner;
use App\Abstracts\Models\Model;

class Brandname extends Model
{
    protected $table = 'v3_brandnames';

    protected $fillable = [
        'name',
        'enabled',
        'partner_id'
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'v3_user_has_brandnames');
    }

    public function pricings()
    {
        return $this->hasMany(BrandnamePricing::class, 'brandname_id');
    }

    public function configs()
    {
        return $this->hasMany(BrandnameConfig::class, 'brandname_id');
    }
}
