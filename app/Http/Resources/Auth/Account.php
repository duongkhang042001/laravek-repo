<?php

namespace App\Http\Resources\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Auth\Editor as EditorResource;
use App\Http\Resources\Auth\Creator as CreatorResource;
use App\Http\Resources\Auth\Permissions as PermissionCollection;
use App\Http\Resources\Auth\Roles as RolesResource;
use App\Http\Resources\Brandname\Brandname as BrandnameResource;
use App\Models\Core\Partner;

class Account extends JsonResource
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
            'partner' => $this->partner_id,
            'username' => $this->username,
            'full_name' => $this->full_name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
            'enabled' => $this->enabled,
            'roles' => $this->partner->roles->pluck('name'),
            'brandnames' => BrandnameResource::collection($this->whenLoaded('brandnames')),
            'permissions' => new PermissionCollection($this->whenLoaded('permissions')),
            'created_by' => new CreatorResource($this->whenLoaded('creator')),
            'updated_by' => new EditorResource($this->whenLoaded('editor')),
            'created_at' => is_null($this->created_at) ? null : Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => is_null($this->updated_at) ? null : Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
        ];
    }
}
