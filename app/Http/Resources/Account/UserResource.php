<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? null,
            'bvn' => $this->bvn ?? null,
            'nin' => $this->nin ?? null,
            'firstname' => $this->firstname ?? null,
            'lastname' => $this->lastname ?? null,
            'middleName' => $this->middle_name ?? null,
            'email' => $this->email ?? null,
            'phoneNumber' => $this->phone_number ?? null,
            'address' => $this->address ?? null,
            'gender' => $this->gender ?? null,
            'dateOfBirth' => $this->date_of_birth ?? null,
            'savingsAccountNumber' => $this->savingsAccount->account_number ?? 'N/A',
            'currentAccountNumber' => $this->currentAccount->account_number ?? 'N/A',
            'corporateAccountNumber' => $this->curAccount->account_number ?? 'N/A',
            'createdAt' => date_format($this->created_at ?? null, 'Y-m-d H:i:s'),

        ];
    }
}
