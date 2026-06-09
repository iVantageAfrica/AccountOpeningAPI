<?php

namespace App\Jobs;

use App\Enum\SupportNotificationEnum;
use App\Models\Account\CorporateAccount;
use App\Models\Account\IndividualAccount;
use App\Models\Account\Referee;
use App\Services\Utility\MessageService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AccountRefereeSubmissionNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly int $refereeId,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $referee = Referee::find($this->refereeId);
        if (!$referee) {
            return;
        }
        $accountData = IndividualAccount::whereJsonContains('referees', $this->refereeId)->first()
            ?? CorporateAccount::whereJsonContains('referees', $this->refereeId)->first();
        if (!$accountData) {
            return;
        }

        $pdf = Pdf::loadView('pdf.referee-submission', [
            'accountData' => $accountData,
            'userData' => $accountData->user,
            'refereeData' => $referee,
        ])->setOptions([
            'isRemoteEnabled' => true,
            'isLocalFileEnabled' => true,
            'chroot' => storage_path('app/public'),
        ]);

        $pdfOutput = $pdf->output();
        MessageService::supportNotificationMessage([
            'accountData' => $accountData,
            'refereeData' => $referee,
            'notificationType' => SupportNotificationEnum::REFEREE_UPDATE->value,
            'attachments' => [[
                'data' => $pdfOutput,
                'mime' => 'application/pdf',
                'name' => "account-{$accountData->account_number}.pdf",
            ]],
        ]);
    }
}
