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

    protected string $bvn;
    protected string $accountNumber;
    protected string $accountType;

    /**
     * Create a new job instance.
     */
    public function __construct(string $bvn, string $accountNumber, string $accountType)
    {
        $this->bvn = $bvn;
        $this->accountNumber = $accountNumber;
        $this->accountType = $accountType;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        MessageService::accountCreationMessage([
            'bvn' => $this->bvn,
            'accountNumber' => $this->accountNumber,
            'accountType' => $this->accountType,
        ]);
    }
}
