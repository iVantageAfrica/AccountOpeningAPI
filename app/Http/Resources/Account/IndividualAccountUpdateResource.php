<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndividualAccountUpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'motherMaidenName' => $this->mother_maiden_name ?? null,
            'phoneNumber' => $this->phone_number ?? null,
            'emailAddress' => $this->email_address ?? null,
            'employmentStatus' => $this->employment_status ?? null,
            'employer' => $this->employer ?? null,
            'accountOfficer' => $this->account_officer ?? null,
            'maritalStatus' => $this->marital_status ?? null,
            'houseNumber' => $this->house_number ?? null,
            'street' => $this->street ?? null,
            'city' => $this->city ?? null,
            'state' => $this->state ?? null,
            'origin' => $this->origin ?? null,
            'lga' => $this->lga ?? null,
            'nextOfKinName' => $this->next_of_kin_name ?? null,
            'nextOfKinAddress' => $this->next_of_kin_address ?? null,
            'nextOfKinPhoneNumber' => $this->next_of_kin_phone_number ?? null,
            'nextOfKinRelationship' => $this->next_of_kin_relationship ?? null,
            'createdAt' => date_format($this->created_at ?? null, 'Y-m-d H:i:s'),
        ];
    }
}
