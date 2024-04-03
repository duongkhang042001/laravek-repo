<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Partners extends ResourceCollection
{
    public $collects = Partner::class;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'data' => $this->collection,
        ];
    }

    public function paginationInformation($request, $paginated, $default)
    {
        return [
            'total' => $default['meta']['total'],
            'page'  => $default['meta']['current_page']
        ];
    }
}
