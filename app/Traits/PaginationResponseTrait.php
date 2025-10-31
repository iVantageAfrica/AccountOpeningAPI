<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait PaginationResponseTrait
{
    use JsonResponseTrait;

    /**
     * @param class-string<JsonResource> $resourceClass
     */
    protected function paginateResponse(string $resourceClass, Builder $query, array $extra = []): JsonResponse
    {
        $all = request()->boolean('all');
        $items = $all ? $query->get() : $query->paginate(10);
        $pagination = $all
            ? [
                'current_page'  => 1,
                'total_page'    => 1,
                'total'         => $items->count(),
                'per_page'      => $items->count(),
                'next_page_url' => null,
                'prev_page_url' => null,
            ]
            : [
                'current_page'  => $items->currentPage(),
                'total_page'    => $items->lastPage(),
                'total'         => $items->total(),
                'per_page'      => $items->perPage(),
                'next_page_url' => $items->nextPageUrl(),
                'prev_page_url' => $items->previousPageUrl(),
            ];

        return $this->successDataResponse(array_merge([
            'data'       => $resourceClass::collection($items),
            'pagination' => $pagination,
        ], $extra));
    }
}
