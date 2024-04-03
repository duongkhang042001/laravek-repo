<?php

namespace App\Abstracts\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Partner;

abstract class Model extends Eloquent
{
    protected static function booted()
    {
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function scopeByPartner(Builder $query)
    {
        $query->where('partner_id', core()->currentUser()->partner_id);
    }
}
