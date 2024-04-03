<?php

namespace App\Http\Resources\Brandname;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Messages extends ResourceCollection
{
    public $collects = Message::class;

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
