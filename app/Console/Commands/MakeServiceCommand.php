<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name : The name of the Service (e.g. Orders/PaymentService)}';
    protected $description = 'Create a new Service class in app/Services';

    public function handle(): void
    {
        $name = str_replace('\\', '/', $this->argument('name'));
        $path = app_path('Services/' . $name . '.php');

        $directory = dirname($path);
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $className = basename($path, '.php');
        $relativeNamespace = str_replace('/', '\\', dirname($name));
        $namespace = 'App\\Services' . ($relativeNamespace !== '.' ? '\\' . $relativeNamespace : '');

        $stub = <<<PHP
<?php

namespace {$namespace};

class {$className}
{
    //
}

PHP;

        File::put($path, $stub);
        $this->info("✅ Service created: {$path}");
    }
}
