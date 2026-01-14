<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DirectoryResource extends JsonResource
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
            'lastname' => $this->lastname ?? null,
            'firstname' => $this->firstname ?? null,
            'othername' => $this->othername ?? null,
            'emailAddress' => $this->email_address ?? null,
            'phoneNumber' => $this->phone_number ?? null,
            'bvn' => $this->bvn ?? null,
            'nin' => $this->nin ?? null,
            'signature' => $this->signature ?? null,
            'passport' => $this->passport ?? null,
            'validId' => $this->valid_id ?? null,
        ];
    }
}
