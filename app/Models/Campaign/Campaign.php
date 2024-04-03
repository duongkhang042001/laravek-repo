<?php

namespace App\Models\Campaign;

use App\Models\Auth\User;
use App\Models\Core\Partner;
use App\Enums\CampaignStatus;
use App\Models\Brandname\Brandname;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use SoftDeletes;

    protected $table = 'v3_campaigns';

    protected $fillable = [
        'partner_id',
        'brandname_id',
        'template_id',
        'file_import_id',
        'code',
        'title',
        'content',
        'type',
        'sms_type',
        'messages_count',
        'messages_invalid_count',
        'messages_deliveried_count',
        'messages_sent_count',
        'sms_count',
        'sms_deliveried_count',
        'sms_failed_count',
        'sms_sent_count',
        'status',
        'is_fully_prepared',
        'confirmed_at',
        'scheduled_at',
        'cancelled_at',
        'approved_at',
        'approved_by',
        'created_by',
        'updated_by'
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function brandname()
    {
        return $this->belongsTo(Brandname::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->select(['id', 'username', 'email', 'full_name']);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by')->select(['id', 'username', 'email', 'full_name']);
    }

    public function isFullyPrepared()
    {
        return ($this->is_fully_prepared === 1);
    }

    public function isApproved()
    {
        return !is_null($this->approved_at);
    }

    public function getPercentageOfProcess()
    {
        if ($this->status < CampaignStatus::sending()->value) {
            return 0;
        }

        return ($this->messages_count > 0) ? round(($this->messages_delivered_count + $this->messages_invalid_count) / $this->messages_count * 100) : 0;
    }

    public function getIncommingMessagesCount()
    {
        if ($this->status < CampaignStatus::sending()->value) {
            return 0;
        }

        return $this->messages_delivered_count + $this->messages_invalid_count;
    }
}
