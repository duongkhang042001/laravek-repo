<?php

namespace App\Http\Resources\Quota;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Quota extends JsonResource
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
            'partner_id' => $this->partner_id,
            'quotas_current_usage' => $this->quotas_current_usage,
            'quotas_limit' => $this->quotas_limit,
        ];
    }
}
