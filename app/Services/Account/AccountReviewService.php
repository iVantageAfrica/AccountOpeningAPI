<?php

namespace App\Services\Account;

use App\Exceptions\CustomException;
use App\Models\Account\CorporateAccount;
use App\Models\Account\IndividualAccount;
use App\Models\Admin;
use Illuminate\Http\Request;

class AccountReviewService
{
    /**
     * CMO marks an account as Reviewed and assigns a Compliance Officer, so it can proceed
     * to Compliance review.
     *
     * @throws CustomException
     */
    public static function cmoReview(array $data, ?Request $request = null): IndividualAccount|CorporateAccount
    {
        $account = self::resolveAccount($data['accountNumber'], $data['accountType']);
        $actor = $request?->user();
        $complianceOfficerId = $data['complianceOfficerId'] ?? null;

        self::ensureNotCompletedOrApproved($account);
        self::ensureNotAlreadyReviewed($account);

        if (!$complianceOfficerId) {
            throw new CustomException('Please select the Compliance Officer to review this account.', 422);
        }

        $officer = Admin::find($complianceOfficerId);
        if (!$officer || !$officer->hasRole('Compliance Officer')) {
            throw new CustomException('The selected Compliance Officer is not valid.', 422);
        }

        $account->update([
            'cmo_status' => 'Reviewed',
            'cmo_reviewed_by' => $actor?->id,
            'cmo_reviewed_at' => now(),
            'cmo_flagged_reason' => null,
            'compliance_assigned_to' => $complianceOfficerId,
            'compliance_assigned_at' => now(),
            'status' => 'Awaiting Compliance Review',
        ]);

        AuditLogService::record(
            $actor?->id,
            'cmo_review',
            "Reviewed {$data['accountType']} account {$account->account_number} and assigned it to Compliance Officer #{$complianceOfficerId}",
            $request,
            ['account_number' => $account->account_number, 'account_type' => $data['accountType'], 'compliance_assigned_to' => $complianceOfficerId]
        );

        return self::fetchRefreshedAccount($data['accountNumber'], $data['accountType']);
    }

    /**
     * CMO flags an account with a reason; it must not proceed until the issue is resolved.
     *
     * @throws CustomException
     */
    public static function cmoFlag(array $data, ?Request $request = null): IndividualAccount|CorporateAccount
    {
        $account = self::resolveAccount($data['accountNumber'], $data['accountType']);
        $actor = $request?->user();

        self::ensureNotCompletedOrApproved($account);
        self::ensureNotAlreadyReviewed($account);

        $account->update([
            'cmo_status' => 'Flagged',
            'cmo_reviewed_by' => $actor?->id,
            'cmo_reviewed_at' => now(),
            'cmo_flagged_reason' => $data['reason'],
        ]);

        AuditLogService::record(
            $actor?->id,
            'cmo_flag',
            "Flagged {$data['accountType']} account {$account->account_number}: {$data['reason']}",
            $request,
            ['account_number' => $account->account_number, 'account_type' => $data['accountType'], 'reason' => $data['reason']]
        );

        return self::fetchRefreshedAccount($data['accountNumber'], $data['accountType']);
    }

    /**
     * Compliance approves a CMO-reviewed account and completes the account opening process.
     *
     * @throws CustomException
     */
    public static function complianceApprove(array $data, ?Request $request = null): IndividualAccount|CorporateAccount
    {
        $account = self::resolveAccount($data['accountNumber'], $data['accountType']);
        $actor = $request?->user();

        self::ensureReviewedByCmo($account);
        self::ensureAssignedToComplianceOfficer($account, $actor);
        if (strtolower($account->compliance_status ?? '') === 'approved') {
            throw new CustomException('This account has already been approved by Compliance.', 422);
        }

        $account->update([
            'compliance_status' => 'Approved',
            'compliance_reviewed_by' => $actor?->id,
            'compliance_reviewed_at' => now(),
            'compliance_flagged_reason' => null,
            'status' => 'Completed',
        ]);

        AuditLogService::record(
            $actor?->id,
            'compliance_approve',
            "Approved {$data['accountType']} account {$account->account_number}",
            $request,
            ['account_number' => $account->account_number, 'account_type' => $data['accountType']]
        );

        return self::fetchRefreshedAccount($data['accountNumber'], $data['accountType']);
    }

    /**
     * Compliance flags an account; the overall account opening status must not become Completed.
     *
     * @throws CustomException
     */
    public static function complianceFlag(array $data, ?Request $request = null): IndividualAccount|CorporateAccount
    {
        $account = self::resolveAccount($data['accountNumber'], $data['accountType']);
        $actor = $request?->user();

        self::ensureReviewedByCmo($account);
        self::ensureAssignedToComplianceOfficer($account, $actor);
        if (strtolower($account->compliance_status ?? '') === 'approved') {
            throw new CustomException('This account has already been approved by Compliance.', 422);
        }

        $updateData = [
            'compliance_status' => 'Flagged',
            'compliance_reviewed_by' => $actor?->id,
            'compliance_reviewed_at' => now(),
            'compliance_flagged_reason' => $data['reason'],
        ];

        if (strtolower($account->status ?? '') === 'completed') {
            $updateData['status'] = 'Pending';
        }

        $account->update($updateData);

        AuditLogService::record(
            $actor?->id,
            'compliance_flag',
            "Flagged {$data['accountType']} account {$account->account_number}: {$data['reason']}",
            $request,
            ['account_number' => $account->account_number, 'account_type' => $data['accountType'], 'reason' => $data['reason']]
        );

        return self::fetchRefreshedAccount($data['accountNumber'], $data['accountType']);
    }

    /**
     * List all active Compliance Officers for the CMO assignment picker.
     */
    public static function listComplianceOfficers(): array
    {
        return Admin::role('Compliance Officer')
            ->orderBy('firstname')
            ->get(['id', 'firstname', 'lastname', 'email'])
            ->map(fn (Admin $admin) => [
                'id' => $admin->id,
                'name' => trim($admin->firstname . ' ' . $admin->lastname),
                'email' => $admin->email,
            ])
            ->toArray();
    }

    /**
     * Accounts awaiting the active Compliance Officer's review.
     */
    public static function awaitingComplianceReviewList(?Request $request = null): array
    {
        $officerId = $request?->user()?->id;
        if (!$officerId) {
            return [];
        }

        $individuals = IndividualAccount::with(['user', 'cmoReviewer'])
            ->where('compliance_assigned_to', $officerId)
            ->whereIn('status', ['Awaiting Compliance Review', 'Pending'])
            ->whereNull('compliance_reviewed_at')
            ->get()
            ->map(fn (IndividualAccount $account) => self::mapQueueItem(
                $account->id,
                $account->account_number,
                (int) $account->account_type_id === 1 ? 'Current' : 'Savings',
                $account->account_type_id,
                trim(($account->user->firstname ?? '') . ' ' . ($account->user->lastname ?? '')),
                $account->status,
                $account->cmoReviewer,
                $account->cmo_reviewed_at,
                $account->created_at
            ));

        $corporates = CorporateAccount::with('cmoReviewer')
            ->where('compliance_assigned_to', $officerId)
            ->whereIn('status', ['Awaiting Compliance Review', 'Pending'])
            ->whereNull('compliance_reviewed_at')
            ->get()
            ->map(fn (CorporateAccount $account) => self::mapQueueItem(
                $account->id,
                $account->account_number,
                'Corporate',
                $account->account_type_id,
                $account->company_name ?? '',
                $account->status,
                $account->cmoReviewer,
                $account->cmo_reviewed_at,
                $account->created_at
            ));

        return $individuals->merge($corporates)->sortByDesc('createdAt')->values()->toArray();
    }

    /**
     * Count of accounts awaiting the active Compliance Officer's review, split by type.
     */
    public static function complianceReviewSummary(?Request $request = null): array
    {
        $officerId = $request?->user()?->id;
        if (!$officerId) {
            return ['total' => 0, 'savings' => 0, 'current' => 0, 'corporate' => 0];
        }

        $query = fn ($model) => $model::where('compliance_assigned_to', $officerId)
            ->whereIn('status', ['Awaiting Compliance Review', 'Pending'])
            ->whereNull('compliance_reviewed_at');

        $individual = $query(IndividualAccount::class);
        $corporate = $query(CorporateAccount::class)->count();

        $savings = (clone $individual)->where('account_type_id', 2)->count();
        $current = (clone $individual)->where('account_type_id', 1)->count();
        $total = $savings + $current + $corporate;

        return ['total' => $total, 'savings' => $savings, 'current' => $current, 'corporate' => $corporate];
    }

    private static function mapQueueItem(
        int $id,
        string $accountNumber,
        string $accountType,
        mixed $accountTypeId,
        string $name,
        string $status,
        mixed $cmoReviewer,
        mixed $cmoReviewedAt,
        mixed $createdAt
    ): array {
        return [
            'id' => $id,
            'accountNumber' => $accountNumber,
            'accountType' => $accountType,
            'accountTypeId' => $accountTypeId,
            'holderName' => $name,
            'status' => $status,
            'cmoReviewedByName' => $cmoReviewer ? trim(($cmoReviewer->firstname ?? '') . ' ' . ($cmoReviewer->lastname ?? '')) : null,
            'cmoReviewedAt' => $cmoReviewedAt ? date_format($cmoReviewedAt, 'Y-m-d H:i:s') : null,
            'createdAt' => $createdAt ? date_format($createdAt, 'Y-m-d H:i:s') : null,
        ];
    }

    /**
     * @throws CustomException
     */
    private static function resolveAccount(string $accountNumber, string $accountType): IndividualAccount|CorporateAccount
    {
        $account = $accountType === 'corporate'
            ? CorporateAccount::whereAccountNumber($accountNumber)->first()
            : IndividualAccount::whereAccountNumber($accountNumber)->first();

        if (!$account) {
            throw new CustomException('Account not found', 404);
        }

        return $account;
    }

    private static function fetchRefreshedAccount(string $accountNumber, string $accountType): IndividualAccount|CorporateAccount
    {
        return $accountType === 'corporate'
            ? AdminService::fetchCorporateAccount($accountNumber)
            : AdminService::fetchIndividualAccount($accountNumber);
    }

    /**
     * @throws CustomException
     */
    private static function ensureNotCompletedOrApproved(IndividualAccount|CorporateAccount $account): void
    {
        if (strtolower($account->status ?? '') === 'completed') {
            throw new CustomException('This account opening has already been completed.', 422);
        }

        if (strtolower($account->compliance_status ?? '') === 'approved') {
            throw new CustomException('This account has already been approved by Compliance.', 422);
        }
    }

    /**
     * @throws CustomException
     */
    private static function ensureNotAlreadyReviewed(IndividualAccount|CorporateAccount $account): void
    {
        if (strtolower($account->cmo_status ?? '') === 'reviewed') {
            throw new CustomException('This account has already been reviewed by a Customer Management Officer.', 422);
        }
    }

    /**
     * @throws CustomException
     */
    private static function ensureReviewedByCmo(IndividualAccount|CorporateAccount $account): void
    {
        if (strtolower($account->cmo_status ?? '') !== 'reviewed') {
            throw new CustomException('This account must be reviewed by a Customer Management Officer before this action.', 422);
        }
    }

    /**
     * A Compliance Officer may only act on accounts assigned to them (Super Admins are exempt).
     *
     * @throws CustomException
     */
    private static function ensureAssignedToComplianceOfficer(IndividualAccount|CorporateAccount $account, mixed $actor): void
    {
        if ($actor && $actor->is_super_admin) {
            return;
        }

        if (!$account->compliance_assigned_to) {
            throw new CustomException('This account has not been assigned to any Compliance Officer yet.', 422);
        }

        if (!$actor || (int) $account->compliance_assigned_to !== (int) $actor->id) {
            throw new CustomException('This account was not assigned to you for review.', 422);
        }
    }
}