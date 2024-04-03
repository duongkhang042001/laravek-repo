<?php

namespace App\Http\Resources\Campaign;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\Brandname\Brandname;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\File\Import as FileImport;

class Campaign extends JsonResource
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
            'brandname' => new Brandname($this->whenLoaded('brandname')),
            'file_import' => new FileImport($this->whenLoaded('file_import')),
            'title' => $this->title,
            'content' => $this->content,
            'code' => $this->code,
            'type' => $this->type,
            'sms_type' => $this->sms_type,
            'messages_count' => $this->messages_count,
            'messages_delivered_count' => $this->messages_delivered_count,
            'messages_succeed_count' => $this->messages_succeed_count,
            'messages_failed_count' => $this->messages_failed_count,
            'messages_invalid_count' => $this->messages_invalid_count,
            'status' => $this->status,
            'percentage_of_process' => $this->getPercentageOfProcess(),
            'is_approved' => is_null($this->approved_at) ? 0 : 1,
            'is_cancelled' => is_null($this->cancelled_at) ? 0 : 1,
            'approved_at' => is_null($this->approved_at) ? null : Carbon::parse($this->approved_at)->format('Y-m-d H:i:s'),
            'cancelled_at' => is_null($this->cancelled_at) ? null : Carbon::parse($this->cancelled_at)->format('Y-m-d H:i:s'),
            'scheduled_at' => is_null($this->scheduled_at) ? null : Carbon::parse($this->scheduled_at)->format('Y-m-d H:i'),
            'created_at' => is_null($this->created_at) ? null : Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => is_null($this->updated_at) ? null : Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
        ];
    }
}
