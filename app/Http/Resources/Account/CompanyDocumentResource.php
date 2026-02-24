<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyDocumentResource extends JsonResource
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
            'cac' => $this->cac ?? null,
            'memart' => $this->memart ?? null,
            'cacCo2' => $this->cac_co2 ?? null,
            'cacCo7' => $this->cac_co7 ?? null,
            'boardResolution' => $this->board_resolution ?? null,
            'declarationForm' => $this->declaration_form ?? null,
            'partnershipResolution' => $this->partnership_resolution ?? null,
            'proprietorDeclaration' => $this->proprietor_declaration ?? null,
            'signatoryMandate' => $this->signatory_mandate ?? null,
            'partnershipDeed' => $this->partnership_deed ?? null,
            'tin' => $this->tin ?? null,
            'societyResolution' => $this->society_resolution ?? null,
            'principalList' => $this->principal_list ?? null,
            'constitution' => $this->constitution ?? null,
            'trusteeList' => $this->trustee_list ?? null,
            'trustDeed' => $this->trust_deed ?? null,
            'trusteeResolution' => $this->trustee_resolution ?? null,
            'nipcCertificate' => $this->nipc_certificate ?? null,
            'businessPermit' => $this->business_permit ?? null,
            'dueDiligence' => $this->due_diligence ?? null,
            'scumlCertificate' => $this->scuml_certificate ?? null,
            'passport' => $this->passport ?? null,
        ];
    }
}
