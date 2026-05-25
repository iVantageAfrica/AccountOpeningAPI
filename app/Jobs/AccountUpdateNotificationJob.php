<?php

namespace App\Jobs;

use App\Enum\SupportNotificationEnum;
use App\Models\Account\IndividualAccount;
use App\Models\Account\IndividualAccountUpdate;
use App\Services\Utility\MessageService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AccountUpdateNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accountNumber,
        public readonly int $accountTypeId,
        public readonly int $accountUpdateId
    ) {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if (in_array($this->accountTypeId, [1, 2], true)) {
            $accountData = IndividualAccount::whereAccountNumber($this->accountNumber)->first();
            if (!$accountData) {
                return;
            }
            $accountUpdateData = IndividualAccountUpdate::find($this->accountUpdateId);
            $pdf = Pdf::loadView('pdf.account-update', [
                'accountData' => $accountData,
                'userData' => $accountData->user,
                'accountUpdateData' => $accountUpdateData,
                'document' => $accountData->document()->orderBy('id', 'asc')->first(),
            ])->setOptions([
                'isRemoteEnabled' => true,
                'isLocalFileEnabled' => true,
                'chroot' => storage_path('app/public'),
            ]);
            $pdfOutput = $pdf->output();
            MessageService::supportNotificationMessage([
                'notificationType' => SupportNotificationEnum::ACCOUNT_UPDATE->value,
                'attachments' => [[
                    'data' => $pdfOutput,
                    'mime' => 'application/pdf',
                    'name' => "account-{$accountData->account_number}.pdf",
                ]],
            ]);
        }
    }
}
