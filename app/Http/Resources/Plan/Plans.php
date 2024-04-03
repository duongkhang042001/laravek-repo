<?php

namespace App\Http\Resources\Plan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Plans extends ResourceCollection
{
    public $collects = Plan::class;

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
            'cursor' => [
                'prev' => $default['meta']['prev_cursor'],
                'next'  => $default['meta']['next_cursor']
            ]
        ];
    }
}
