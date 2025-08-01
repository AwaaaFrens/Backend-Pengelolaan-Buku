<?php

namespace App\Helpers;

class PaginateHelper
{
    public static function format($data): array
    {
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
}
