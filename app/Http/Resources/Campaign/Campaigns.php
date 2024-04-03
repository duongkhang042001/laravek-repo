<?php

namespace App\Http\Resources\Campaign;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Campaigns extends ResourceCollection
{
    public $collects = Campaign::class;

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
