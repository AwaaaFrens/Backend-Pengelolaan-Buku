<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateHelper
{
    public static function format($data): array
    {
        Log::info('PaginateHelper received data type: ' . get_class($data));

        if ($data instanceof LengthAwarePaginator) {
            return [
                'data' => $data->items(),
                'meta' => [
                    'current_page' => $data->currentPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                    'last_page' => $data->lastPage(),
                    'next_page_url' => $data->nextPageUrl(),
                    'prev_page_url' => $data->prevPageUrl()
                ]
            ];
        }

        if ($data instanceof Collection) {
            return [
                'data' => $data->toArray(),
                'meta' => [
                    'current_page' => 1,
                    'per_page' => $data->count(),
                    'total' => $data->count(),
                    'last_page' => 1,
                    'next_page_url' => null,
                    'prev_page_url' => null
                ]
            ];
        }

        return [
            'data' => is_array($data) ? $data : [$data],
            'meta' => [
                'current_page' => 1,
                'per_page' => is_array($data) ? count($data) : 1,
                'total' => is_array($data) ? count($data) : 1,
                'last_page' => 1,
                'next_page_url' => null,
                'prev_page_url' => null
            ]
        ];
    }
}
