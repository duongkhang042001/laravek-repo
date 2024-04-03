<?php

namespace App\Http\Resources\Core;

use App\Http\Resources\Auth\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Partner extends JsonResource
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
            'name' => $this->name,
            'brandname_ids' => $this->brandnames,
            'modules' => $this->roles->pluck('name'),
            'enabled' => $this->enabled,
            'created_at' => date('Y-m-d H:i:s', strtotime($this->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($this->updated_at))
        ];
    }
}
