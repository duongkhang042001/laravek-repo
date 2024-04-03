<?php

namespace App\Models\File;

use Illuminate\Database\Eloquent\Model;
use App\Models\Core\Partner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\User;

class Export extends Model
{
    use SoftDeletes;

    protected $table = 'v3_file_exports';

    protected $fillable = [
        'user_id',
        'partner_id',
        'name',
        'path',
        'path_hash',
        'size',
        'status',
        'from',
        'to',
        'module'
    ];


    protected static function booted()
    {
        static::creating(function (Export $model) {
            $model->user_id = core()->currentUser()->id;

            $model->partner_id = core()->currentUser()->partner_id;
        });
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function scopeByPartner(Builder $query)
    {
        $query->where('partner_id', core()->currentUser()->partner_id);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id')->select(['id', 'email', 'full_name']);
    }

    public function scopeByCreator(Builder $query)
    {
        $query->where('user_id', core()->currentUser()->id);
    }

    public function getLinkUrl()
    {
        return config('services.static.url') . '/' . $this->path;
    }
}
