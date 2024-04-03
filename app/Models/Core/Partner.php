<?php

namespace App\Models\Core;

use App\Models\Auth\User;

use App\Models\Brandname\Brandname;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasRoles;

    protected $table = 'v3_partners';

    protected $fillable = [
        'name',
        'enabled'
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'partner_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'partner_id');
    }

    public function brandnames()
    {
        return $this->belongsToMany(Brandname::class, 'v3_partner_brandnames');
    }
}
