<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SignatoryResource extends JsonResource
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
            'name' => $this->name ?? null,
            'emailAddress' => $this->email_address ?? null,
            'phoneNumber' => $this->phone_number ?? null,
            'bvn' => $this->bvn ?? null,
            'nin' => $this->nin ?? null,
            'signature' => $this->signature ?? null,
            'passport' => $this->passport ?? null,
            'proofOfAddress' => $this->proof_of_address ?? null,
            'specimenSignature' => $this->specimen_signature ?? null,
            'partnershipDeed' => $this->partnership_deed ?? null,
            'modeOfOperation' => $this->mode_of_operation ?? null,
            'jointMandate' => $this->joint_mandate ?? null,
            'boardApprove' => $this->board_approve ?? null,
        ];
    }
}
