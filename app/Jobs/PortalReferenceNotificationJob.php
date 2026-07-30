<?php

namespace App\Jobs;

use App\Enum\SupportNotificationEnum;
use App\Models\Account\Referee;
use App\Services\Utility\MessageService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PortalReferenceNotificationJob implements ShouldQueue
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
        $referee = Referee::whereId($this->refereeId)
            ->whereIsPortalReference(true)
            ->first();

        if (!$referee) {
            return;
        }


        $pdf = Pdf::loadView('pdf.portal-reference-submission', [
            'refereeData' => $referee,
        ])->setOptions([
            'isRemoteEnabled' => true,
            'isLocalFileEnabled' => true,
            'chroot' => storage_path('app/public'),
        ]);

        $pdfOutput = $pdf->output();
        MessageService::portalReferenceNotification([
            'refereeData' => $referee,
            'notificationType' => SupportNotificationEnum::REFEREE_CREATE->value,
            'attachments' => [[
                'data' => $pdfOutput,
                'mime' => 'application/pdf',
                'name' => "account-{$referee->account_number}.pdf",
            ]],
        ]);
    }
}
