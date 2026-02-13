<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RefereeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name ?? null,
            'emailAddress' => $this->email_address ?? null,
            'phoneNumber' => $this->phone_number ?? null,
            'mobileNumber' => $this->mobile_number ?? null,
            'bankName' => $this->bank_name ?? null,
            'accountName' => $this->account_name ?? null,
            'accountNumber' => $this->account_number ?? null,
            'accountType' => $this->account_type ?? null,
            'knownPeriod' => $this->know_period ?? null,
            'comment' => $this->comment ?? null,
            'signature' => $this->signature ?? null,
        ];
    }
}
