<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'adminId' => $this->admin_id,
            'adminName' => $this->admin ? ($this->admin->firstname . ' ' . $this->admin->lastname) : null,
            'action' => $this->action,
            'description' => $this->description,
            'ipAddress' => $this->ip_address,
            'userAgent' => $this->user_agent,
            'metadata' => $this->metadata,
            'createdAt' => $this->created_at,
        ];
    }
}
