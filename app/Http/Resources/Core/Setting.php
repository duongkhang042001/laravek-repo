<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Setting extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'authenticateEnabled2FA' => $this->get('authenticate.enabled2FA', 'yes') === 'yes',
            'campaignAutoApproval' => $this->get('campaign.autoApproval', 'yes') === 'yes'
        ];
    }
}
