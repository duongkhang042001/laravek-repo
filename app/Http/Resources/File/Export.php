<?php

namespace App\Http\Resources\File;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Auth\Creator as CreatorResource;

class Export extends JsonResource
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
            'creator' => new CreatorResource($this->whenLoaded('creator')), // Who creates this file export
            'name' => $this->name,
            'path_hash' => $this->path_hash,
            'size' => $this->size,
            'from' => is_null($this->from) ? null : Carbon::parse($this->from)->format('Y-m-d'),
            'to' => is_null($this->to) ? null : Carbon::parse($this->to)->format('Y-m-d'),
            'module' => $this->module,
            'status' => $this->status,
            'created_at' => is_null($this->created_at) ? null : Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => is_null($this->updated_at) ? null : Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
        ];
    }
}
