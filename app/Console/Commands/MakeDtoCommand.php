<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeDtoCommand extends Command
{
    protected $signature = 'make:dto {name : The name of the DTO (e.g. Auth/LoginDto)}';
    protected $description = 'Create a new Data Transfer Object (DTO) class in app/DTO';

    public function handle(): void
    {
        $name = str_replace('\\', '/', $this->argument('name'));
        $path = app_path('DTO/' . $name . '.php');

        $directory = dirname($path);
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $className = basename($path, '.php');
        $relativeNamespace = str_replace('/', '\\', dirname($name));
        $namespace = 'App\\DTO' . ($relativeNamespace !== '.' ? '\\' . $relativeNamespace : '');

        $stub = <<<PHP
<?php

namespace {$namespace};

class {$className}
{
    //
}

PHP;

        File::put($path, $stub);
        $this->info("✅ DTO created: {$path}");
    }
}
