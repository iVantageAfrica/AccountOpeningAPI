<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'validId' => $this->valid_id ?? null,
            'signature' => $this->signature ?? null,
            'utilityBill' => $this->utility_bill ?? null,
            'passport' => $this->passport ?? null,
            'name' => $this->name ?? null,
        ];
    }
}
