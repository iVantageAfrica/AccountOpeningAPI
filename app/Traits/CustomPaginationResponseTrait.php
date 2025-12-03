<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait CustomPaginationResponseTrait
{
    use JsonResponseTrait;

    protected function customPaginationResponse(
        Builder $query,
        Request $request,
        string $resourceClass,
        array $searchableColumns = [],
        array $extra = [],
        int|string $defaultDataLength = 200,
        int $perPage = 10,
    ): JsonResponse {
        $page = max((int) $request->get('page', 1), 1);
        $search = $request->get('search');
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');
        $dataLengthParam = $request->get('dataLength');

        // Apply search filters
        if ($search && !empty($searchableColumns)) {
            $query->where(function ($q) use ($search, $searchableColumns) {
                foreach ($searchableColumns as $column) {
                    $q->orWhere($column, 'ILIKE', "%{$search}%");
                }
            });
        }

        // Apply date range filters
        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            if (strlen($startDate) === 10) {
                $start = $start->startOfDay();
            }
            if (strlen($endDate) === 10) {
                $end = $end->endOfDay();
            }
            $query->whereBetween('created_at', [$start, $end]);
            $dataLengthParam = 'all';
        }

        // Determine mode: numeric/all → fetch all, dummy pagination
        $fetchAll = ($dataLengthParam === 'all') || (is_numeric($dataLengthParam) && $dataLengthParam > 0) || $search || ($startDate && $endDate);
        if ($fetchAll) {
            $items = $query->orderByDesc('created_at')
                ->when(is_numeric($dataLengthParam), fn ($q) => $q->limit($dataLengthParam))
                ->get();

            return $this->successDataResponse(array_merge([
                'data' => $resourceClass::collection($items),
                'pagination' => $this->dummyPagination($items->count()),
            ], $extra));
        }

        $items = $query->orderByDesc('created_at')
            ->limit($defaultDataLength)
            ->get();

        $total = $items->count();
        $sliced = $items->slice(($page - 1) * $perPage, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $sliced,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return $this->successDataResponse(array_merge([
            'data' => $resourceClass::collection($sliced),
            'pagination' => [
                'current_page'  => $paginator->currentPage(),
                'total_page'    => $paginator->lastPage(),
                'total'         => $paginator->total(),
                'per_page'      => $paginator->perPage(),
                'next_page_url' => $paginator->nextPageUrl(),
                'prev_page_url' => $paginator->previousPageUrl(),
            ],
        ], $extra));
    }

    private function dummyPagination(int $count): array
    {
        return [
            'current_page'  => 1,
            'total_page'    => 1,
            'total'         => $count,
            'per_page'      => $count,
            'next_page_url' => null,
            'prev_page_url' => null,
        ];
    }
}
