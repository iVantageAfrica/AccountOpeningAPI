<?php

namespace App\Jobs;

use App\Services\Utility\MessageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AccountNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $bvn,
        public readonly string $accountNumber,
        public readonly int $accountTypeId,
        public readonly string $accountType,
        public readonly ?string $bankAccountReferenceUrl,
        public readonly ?string $username,
        public readonly ?string $password,
        public readonly ?string $pin,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        MessageService::accountCreationMessage([
            'bvn' => $this->bvn,
            'accountNumber' => $this->accountNumber,
            'accountTypeId' => $this->accountTypeId,
            'accountType' => $this->accountType,
            'accountReferenceUrl' => $this->bankAccountReferenceUrl,
            'username' => $this->username,
            'password' => $this->password,
            'pin' => $this->pin,
        ]);
    }
}
