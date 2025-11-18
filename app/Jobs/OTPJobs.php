<?php

namespace App\Jobs;

use App\Models\Utility\Otp;
use App\Services\Utility\MessageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Random\RandomException;

class OTPJobs implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected string $email;
    protected string $purpose;
    protected string $code;
    protected ?string $reference;

    /**
     * Create a new job instance.
     */
    public function __construct(string $code, string $email, string $purpose, ?string $reference = null)
    {
        $this->code = $code;
        $this->email = $email;
        $this->purpose = $purpose;
        $this->reference = $reference;
    }

    /**
     * Execute the job.
     * @throws RandomException
     */
    public function handle(): void
    {
        $existingOtp = Otp::whereEmailAddress(strtolower($this->email))
            ->wherePurpose($this->purpose)
            ->whereStatus(false)
            ->where('expires_at', '>', now())
            ->orderByDesc('created_at')
            ->first();

        if ($existingOtp && $existingOtp->created_at->diffInMinutes(now()) < 3) {
            return;
        }

        MessageService::createOTPCode($this->code, $this->email, $this->purpose, $this->reference);
    }
}
