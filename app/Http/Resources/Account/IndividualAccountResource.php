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
            'cmoStatus' => $this->cmo_status ?? null,
            'complianceStatus' => $this->compliance_status ?? null,
            'createdAt' => date_format($this->created_at ?? null, 'Y-m-d H:i:s'),
        ];
        $userData = collect((new UserResource($this->user))->resolve())
            ->except(['id', 'createdAt'])
            ->toArray();
        $basic = array_merge($basic, $userData);

        if (!$this->fullDetails) {
            return $basic;
        }

        return array_merge($basic, [
            'accountTypeId' => $this->account_type_id ?? null,
            'mobilePhoneNumber' => $this->phone_number ?? null,
            'lga' => $this->lga ?? null,
            'origin' => $this->origin ?? null,
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
            'accountOfficer' => $this->account_officer ?? null,
            'occupation' => $this->occupation ?? null,
            'cmoReviewedByName' => $this->whenLoaded('cmoReviewer', fn() => $this->cmoReviewer ? trim($this->cmoReviewer->firstname . ' ' . $this->cmoReviewer->lastname) : null),
            'cmoReviewedAt' => $this->cmo_reviewed_at ? date_format($this->cmo_reviewed_at, 'Y-m-d H:i:s') : null,
            'cmoFlaggedReason' => $this->cmo_flagged_reason ?? null,
            'complianceReviewedByName' => $this->whenLoaded('complianceReviewer', fn() => $this->complianceReviewer ? trim($this->complianceReviewer->firstname . ' ' . $this->complianceReviewer->lastname) : null),
            'complianceReviewedAt' => $this->compliance_reviewed_at ? date_format($this->compliance_reviewed_at, 'Y-m-d H:i:s') : null,
            'complianceFlaggedReason' => $this->compliance_flagged_reason ?? null,
            'complianceAssignedTo' => $this->compliance_assigned_to ?? null,
            'complianceAssignedToName' => $this->whenLoaded('complianceAssignee', fn() => $this->complianceAssignee ? trim($this->complianceAssignee->firstname . ' ' . $this->complianceAssignee->lastname) : null),
            'complianceAssignedAt' => $this->compliance_assigned_at ? date_format($this->compliance_assigned_at, 'Y-m-d H:i:s') : null,
            'documents' => DocumentResource::collection($this->whenLoaded('document')),
            'referee' => RefereeResource::collection($this->getRelationValue('referees') ?? []),
            'accountUpdates' => IndividualAccountUpdateResource::collection($this->whenLoaded('accountUpdates')),
        ]);
    }

}
