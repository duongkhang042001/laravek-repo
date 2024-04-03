<?php

namespace App\Http\Resources\Brandname;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Message extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'campaign' => new MessageCampaign($this->whenLoaded('campaign')),
            'sender' => $this->sender,
            'recipent' => $this->recipent,
            'telco' => $this->telco,
            'text' => $this->text,
            'status' => $this->getStatus(),
            'sms_type' => $this->sms_type,
            'sms_count' => $this->sms_count,
            'error' => $this->error,
            'is_delivered' => $this->is_delivered,
            'delivered_at' => is_null($this->delivered_at) ? null : Carbon::parse($this->delivered_at)->format('Y-m-d H:i:s')
        ];
    }
}
