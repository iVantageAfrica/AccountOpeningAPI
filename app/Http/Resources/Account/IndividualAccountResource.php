<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Resources\Json\JsonResource;

class IndividualAccountResource extends JsonResource
{
    protected bool $fullDetails = false;
    public function __construct($resource, bool $fullDetails = false)
    {
        parent::__construct($resource);
        $this->fullDetails = $fullDetails;
    }


    public function withFullDetails(bool $fullDetails = false): self
    {
        $this->fullDetails = $fullDetails;
        return $this;
    }

    public static function collection($resource, bool $fullDetails = false)
    {
        return parent::collection($resource)->map(function ($item) use ($fullDetails) {
            return (new static($item))->withFullDetails($fullDetails);
        });
    }

    public function toArray($request): array
    {
        $basic = [
            'id' => $this->id ?? null,
            'title' => $this->title ??  null,
            'accountNumber' => $this->account_number ?? null,
            'motherMaidenName' => $this->mother_maiden_name ?? null,
            'status' => $this->status ?? null,
        ];
        $userData = (new UserResource($this->user))->resolve();
        unset($userData['id']);
        $basic = array_merge($basic, $userData);

        if (!$this->fullDetails) {
            return $basic;
        }

        return array_merge($basic, [
            'mobilePhoneNumber' => $this->phone_number ?? null,
            'employmentStatus' => $this->employment_status ?? null,
            'employerAddress' => $this->employer_address ?? null,
            'employer' => $this->employer ?? null,
            'maritalStatus' => $this->marital_status ?? null,
            'address' => $this->address ?? null,
            'nextOfKinName' => $this->next_of_kin_name ?? null,
            'nextOfKinAddress' => $this->next_of_kin_address ?? null,
            'nextOfKinRelationship' => $this->next_of_kin_relationship ?? null,
            'nextOfKinPhoneNumber' => $this->next_of_kin_phone_number ?? null,
            'documentId' => $this->document_id ?? null,
            'debitCard' => $this->debit_card ?? null,
            'status' => $this->status ?? null,
            'referrer' => $this->referrer ?? null,
            'occupation' => $this->occupation ?? null,
            'createdAt' => date_format($this->created_at ?? null, 'Y-m-d H:i:s'),
            'documents' => DocumentResource::make($this->whenLoaded('document')),
            'referee' => RefereeResource::collection($this->getRelationValue('referees') ?? []),
        ]);
    }

}
