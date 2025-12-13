<?php

namespace App\Jobs;

use App\Services\Utility\MessageService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AccountReferenceJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use \Illuminate\Bus\Queueable;
    use SerializesModels;

    protected string $refereeName;
    protected string $refereeEmail;
    protected string $accountName;
    protected string $bankAccountReferenceUrl;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->refereeName = $data['name'];
        $this->accountName = $data['account_name'];
        $this->bankAccountReferenceUrl = $data['url'];
        $this->refereeEmail = $data['email'];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        MessageService::accountReferenceMessage([
            'refereeName' => $this->refereeName,
            'accountName' => $this->accountName,
            'email' => $this->refereeEmail,
            'accountReferenceUrl' => $this->bankAccountReferenceUrl,
        ]);
    }
}
