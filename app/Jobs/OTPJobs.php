<?php

namespace App\Jobs;

use App\Models\Utility\Otp;
use App\Services\Utility\MessageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class OTPJobs implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected string $email;
    protected string $purpose;
    protected string $code;

    /**
     * Create a new job instance.
     */
    public function __construct(string $code, string $email, string $purpose)
    {
        $this->code = $code;
        $this->email = $email;
        $this->purpose = $purpose;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $existingOtp = Otp::whereEmailAddress($this->email)
            ->wherePurpose($this->purpose)
            ->where('expires_at', '>', now())
            ->orderByDesc('created_at')
            ->first();

        if ($existingOtp && $existingOtp->created_at->diffInMinutes(now()) < 3) {
            return;
        }

        MessageService::createOTPCode($this->code, $this->email, $this->purpose);
    }
}
