<?php

namespace App\Models\Brandname;

use App\Enums\SMSStatus;
use App\Models\Core\Partner;
use App\Models\Campaign\Campaign;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $table = 'v3_messages';

    protected $fillable = [
        'provider',
        'partner_id',
        'telco',
        'brandname_id',
        'campaign_id',
        'sender',
        'recipent',
        'sms_type',
        'sms_count',
        'text',
        'scheduled_at',
        'delivered_at',
        'is_delivered',
        'is_sent',
        'sent_at',
        'is_otp',
        'is_unicode',
        'is_encrypted',
        'tries',
        'error'
    ];

    const UPDATED_AT = null;

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function getStatus(): int
    {
        if ($this->is_delivered === 0) {
            return SMSStatus::awaiting_send()->value;
        }

        if ($this->is_sent === 1) {
            return SMSStatus::succeed()->value;
        }

        if ($this->error > 0) {
            return SMSStatus::failed()->value;
        }

        return SMSStatus::sent()->value;
    }
}
