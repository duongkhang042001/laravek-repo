<?php

namespace App\Models\Auth;

use App\Models\Core\Partner;
use App\Models\Brandname\Brandname;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $table = 'v3_users';

    protected $fillable = [
        'partner_id',
        'username',
        'full_name',
        'phone_number',
        'enabled',
        'email',
        'password',
        'created_by',
        'updated_by'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->select(['id', 'email', 'full_name']);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by')->select(['id', 'email', 'full_name']);
    }

    public function brandnames()
    {
        return $this->belongsToMany(Brandname::class, 'v3_user_has_brandnames');
    }
    public function isAdmin()
    {
        return $this->is_admin;
    }
}
