<?php

namespace App\Jobs;

use App\Services\Utility\MessageService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SignatoryDirectoryJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use \Illuminate\Bus\Queueable;
    use SerializesModels;

    protected string $name;
    protected string $email;
    protected string $businessName;
    protected string $type;
    protected string $url;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->email = $data['emailAddress'];
        $this->businessName = $data['businessName'];
        $this->type = $data['type'];
        $this->url = $data['url'];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        MessageService::accountSignatoryDirectoryMessage([
            'name' => $this->name,
            'email' => $this->email,
            'businessName' => $this->businessName,
            'type' => $this->type,
            'url' => $this->url,
        ]);
    }
}
