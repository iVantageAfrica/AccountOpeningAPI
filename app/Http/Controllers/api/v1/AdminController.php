<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AccountUpdateLinkRequest;
use App\Http\Requests\Admin\AssignRoleRequest;
use App\Http\Requests\Admin\AuthenticateRequest;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\FlagAccountRequest;
use App\Http\Requests\Admin\ReviewAccountRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Http\Resources\Account\CorporateAccountResource;
use App\Http\Resources\Account\DebitCardResource;
use App\Http\Resources\Account\IndividualAccountResource;
use App\Http\Resources\Account\RefereeResource;
use App\Http\Resources\Account\UserResource;
use App\Services\Account\AccountReviewService;
use App\Services\Account\AdminService;
use App\Services\Account\AuditLogService;
use App\Traits\CustomPaginationResponseTrait;
use App\Traits\JsonResponseTrait;
use App\Utils\QueryParamValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonException;
use Random\RandomException;

class AdminController extends Controller
{
    use JsonResponseTrait;
    use CustomPaginationResponseTrait;

    /**
     * @throws CustomException|RandomException
     */
    public function authenticate(AuthenticateRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->successDataResponse(AdminService::authenticate($data, $request));
    }

    //    /**
    //     * @throws JsonException
    //     */
    //    public function dataLink(Request $request): JsonResponse
    //    {
    //        AdminService::dataLink();
    //        return $this->successResponse(message: "Data link sent successfully.");
    //    }

    public function customers(Request $request): JsonResponse
    {
        $customerList = AdminService::customerList();
        return $this->customPaginationResponse($customerList, $request, UserResource::class, ['bvn', 'firstname', 'lastname', 'phone_number']);
    }

    public function customerSummary(Request $request): JsonResponse
    {
        return $this->successDataResponse(AdminService::customerSummary());
    }

    public function listSavingsAccount(Request $request): JsonResponse
    {
        $savingsAccount = AdminService::individualAccount(2);
        return $this->customPaginationResponse($savingsAccount, $request, IndividualAccountResource::class, ['account_number','status']);
    }

    public function savingsAccountSummary(Request $request): JsonResponse
    {
        return $this->successDataResponse(AdminService::individualAccountSummary(2));
    }

    public function listCurrentAccount(Request $request): JsonResponse
    {
        $savingsAccount = AdminService::individualAccount(1);
        return $this->customPaginationResponse($savingsAccount, $request, IndividualAccountResource::class, ['account_number', 'status']);
    }

    public function currentAccountSummary(Request $request): JsonResponse
    {
        return $this->successDataResponse(AdminService::individualAccountSummary(1));
    }

    public function listCorporateAccount(Request $request): JsonResponse
    {
        $corporateAccount = AdminService::corporateAccountList('3');
        return $this->customPaginationResponse($corporateAccount, $request, CorporateAccountResource::class, ['account_number', 'status']);
    }
    public function listPOSAccount(Request $request): JsonResponse
    {
        $corporateAccount = AdminService::corporateAccountList('4');
        return $this->customPaginationResponse($corporateAccount, $request, CorporateAccountResource::class, ['account_number', 'status']);
    }
    public function listPortalReferenceAccount(Request $request): JsonResponse
    {
        $portalReferenceAccount = AdminService::portalReferenceAccountList();
        return $this->customPaginationResponse($portalReferenceAccount, $request, RefereeResource::class, ['account_number']);
    }


    public function corporateAccountSummary(Request $request): JsonResponse
    {
        return $this->successDataResponse(AdminService::corporateAccountSummary(3));
    }
    public function POSAccountSummary(Request $request): JsonResponse
    {
        return $this->successDataResponse(AdminService::corporateAccountSummary(4));
    }

    public function portalReferenceSummary(Request $request): JsonResponse
    {
        return $this->successDataResponse(AdminService::portalReferenceSummary());
    }


    /**
     * @throws CustomException
     */
    public function fetchIndividualAccount(Request $request): JsonResponse
    {
        ['accountNumber' => $accountNumber] = QueryParamValidator::getRequiredParams($request, ['accountNumber']);
        return $this->successDataResponse(IndividualAccountResource::make(AdminService::fetchIndividualAccount($accountNumber), true));
    }

    /**
     * @throws CustomException
     */
    public function fetchCorporateAccount(Request $request): JsonResponse
    {
        ['accountNumber' => $accountNumber] = QueryParamValidator::getRequiredParams($request, ['accountNumber']);
        return $this->successDataResponse(CorporateAccountResource::make(AdminService::fetchCorporateAccount($accountNumber), true));
    }

    public function listDebitCardRequest(): JsonResponse
    {
        $debitCardRequest = AdminService::listCardsRequest();
        return $this->successDataResponse(new DebitCardResource($debitCardRequest));
    }

    /**
     * @throws RandomException
     */
    public function accountUpdateLink(AccountUpdateLinkRequest $request): JsonResponse
    {
        $data = $request->validated();
        AdminService::accountUpdateLinkNotification($data);
        return $this->successResponse(message: 'Account update link sent successfully.');
    }

    /**
     * @throws CustomException
     */
    public function assignRole(AssignRoleRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->successDataResponse(AdminService::assignRole($data, $request));
    }


    /**
     * @throws CustomException
     */
    public function createAdmin(CreateAdminRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->successDataResponse(AdminService::createAdmin($data, $request));
    }

    public function listAdmins(): JsonResponse
    {
        return $this->successDataResponse(AdminService::listAdmins());
    }

    /**
     * @throws CustomException
     */
    public function fetchAdmin(Request $request): JsonResponse
    {
        ['adminId' => $adminId] = QueryParamValidator::getRequiredParams($request, ['adminId']);
        return $this->successDataResponse(AdminService::fetchAdmin((int) $adminId));
    }

    /**
     * @throws CustomException
     */
    public function updateAdmin(UpdateAdminRequest $request, int $adminId): JsonResponse
    {
        $data = $request->validated();
        return $this->successDataResponse(AdminService::updateAdmin($data, $adminId, $request));
    }

    /**
     * @throws CustomException
     */
    public function deleteAdmin(Request $request, int $adminId): JsonResponse
    {
        AdminService::deleteAdmin($adminId, $request);
        return $this->successResponse(message: 'Admin deleted successfully.');
    }

    /**
     * @throws CustomException
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $data = $request->validated();
        $adminId = $request->user()->id;
        return $this->successDataResponse(AdminService::updateProfile($data, $adminId, $request));
    }

    /**
     * @throws CustomException
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
        $adminId = $request->user()->id;
        AdminService::changePassword($data, $adminId, $request);
        return $this->successResponse(message: 'Password changed successfully.');
    }

    /**
     * @throws JsonException
     */
    public function listAuditLogs(Request $request): JsonResponse
    {
        $adminId = $request->get('adminId') ? (int) $request->get('adminId') : null;
        $action = $request->get('action');
        $from = $request->get('from');
        $to = $request->get('to');

        $query = AuditLogService::list($adminId, $action, $from, $to);
        return $this->customPaginationResponse($query, $request, \App\Http\Resources\Admin\AuditLogResource::class, ['description']);
    }

    /**
     * CMO - Reviewed
     *
     * @throws CustomException
     */
    public function cmoReviewAccount(ReviewAccountRequest $request): JsonResponse
    {
        $data = $request->validated();
        $account = AccountReviewService::cmoReview($data, $request);
        return $this->successDataResponse($this->reviewResource($account, $data['accountType']));
    }

    /**
     * CMO - Flagged
     *
     * @throws CustomException
     */
    public function cmoFlagAccount(FlagAccountRequest $request): JsonResponse
    {
        $data = $request->validated();
        $account = AccountReviewService::cmoFlag($data, $request);
        return $this->successDataResponse($this->reviewResource($account, $data['accountType']));
    }

    /**
     * Compliance - Approved
     *
     * @throws CustomException
     */
    public function complianceApproveAccount(ReviewAccountRequest $request): JsonResponse
    {
        $data = $request->validated();
        $account = AccountReviewService::complianceApprove($data, $request);
        return $this->successDataResponse($this->reviewResource($account, $data['accountType']));
    }

    /**
     * Compliance - Flagged
     *
     * @throws CustomException
     */
    public function complianceFlagAccount(FlagAccountRequest $request): JsonResponse
    {
        $data = $request->validated();
        $account = AccountReviewService::complianceFlag($data, $request);
        return $this->successDataResponse($this->reviewResource($account, $data['accountType']));
    }

    private function reviewResource(mixed $account, string $accountType): IndividualAccountResource|CorporateAccountResource
    {
        return $accountType === 'corporate'
            ? CorporateAccountResource::make($account, true)
            : IndividualAccountResource::make($account, true);
    }
}
