<?php

namespace App\Http\Resources\Account;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DebitCardResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $today = Carbon::today();

        return [
            'summary' => [
                'totalRequests' => $this->collection->count(),
                'pendingRequests' => $this->collection->where('status', 'Pending')->count(),
                'approvedRequests' => $this->collection->where('status', 'APPROVED')->count(),
                'todayRequests' => $this->collection->filter(function ($item) use ($today) {
                    return $item->created_at->isSameDay($today);
                })->count(),
            ],
            'data' => $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'userId' => $item->user_id,
                    'accountTypeId' => $item->account_type_id,
                    'accountNumber' => $item->account_number,
                    'status' => $item->status,
                    'firstname' => $item->user->firstname ?? null,
                    'lastname' => $item->user->lastname ?? null,
                    'accountType' => $item->accountType->name ?? null,
                    'createdAt' => $item->created_at,
                ];
            })->all(),
        ];
    }
}
