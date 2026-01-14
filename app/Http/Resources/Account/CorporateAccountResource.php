<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Resources\Json\JsonResource;

class CorporateAccountResource extends JsonResource
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
            'accountNumber' => $this->account_number ?? null,
            'companyName' => $this->company_name ?? null,
            'registrationNumber' => $this->registration_number ?? null,
            'companyType' => $this->companyType->name ?? null,
            'tin' => $this->tin ?? null,
            'companyAddress' => $this->address ?? null,
            'phoneNumber' => $this->phone_number ?? null,
            'businessEmail' => $this->business_email ?? null,
            'city' => $this->city ?? null,
            'lga' => $this->lga ?? null,
            'state' => $this->state ?? null,
            'accountOfficer' => $this->account_officer ?? null,
            'debitCard' => $this->debit_card ?? null,
            'status' => $this->status ?? null,
            'createdAt' => date_format($this->created_at ?? null, 'Y-m-d H:i:s'),
        ];
        $userData = (new UserResource($this->user))->resolve();
        unset($userData['id']);
        $basic = array_merge($basic, $userData);

        if (!$this->fullDetails) {
            return $basic;
        }

        return array_merge($basic, [
            'companyDocument' => CompanyDocumentResource::make($this->whenLoaded('companyDocument')),
            'createdAt' => date_format($this->created_at ?? null, 'Y-m-d H:i:s'),
            'documents' => DocumentResource::make($this->whenLoaded('document')),
            'referee' => RefereeResource::collection($this->getRelationValue('referees') ?? []),
            'signatory' => SignatoryResource::collection($this->getRelationValue('signatories') ?? []),
            'directory' => DirectoryResource::collection($this->getRelationValue('directories') ?? []),
        ]);
    }
}
