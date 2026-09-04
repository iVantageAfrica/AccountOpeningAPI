<?php

namespace App\Services\Account;

use App\Exceptions\CustomException;
use App\Models\Account\CorporateAccount;
use App\Models\Account\IndividualAccount;
use Illuminate\Http\Request;

class AccountReviewService
{
    /**
     * CMO marks an account as Reviewed so it can proceed to Compliance review.
     *
     * @throws CustomException
     */
    public static function cmoReview(array $data, ?Request $request = null): IndividualAccount|CorporateAccount
    {
        $account = self::resolveAccount($data['accountNumber'], $data['accountType']);
        $actor = $request?->user();

        self::ensureNotCompletedOrApproved($account);
        self::ensureNotAlreadyReviewed($account);

        $account->update([
            'cmo_status' => 'Reviewed',
            'cmo_reviewed_by' => $actor?->id,
            'cmo_reviewed_at' => now(),
            'cmo_flagged_reason' => null,
        ]);

        AuditLogService::record(
            $actor?->id,
            'cmo_review',
            "Reviewed {$data['accountType']} account {$account->account_number}",
            $request,
            ['account_number' => $account->account_number, 'account_type' => $data['accountType']]
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
}