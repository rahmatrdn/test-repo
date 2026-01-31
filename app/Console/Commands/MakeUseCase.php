<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeUseCase extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'make:usecase {name}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new Use Case class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $directory = app_path('Usecase');
        $path = $directory . "/{$name}.php";

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($path)) {
            $this->error("Use case {$name} already exists.");
            return Command::FAILURE;
        }

        file_put_contents($path, $this->stub($name));

        $this->info("Use case {$name} created successfully.");
        return Command::SUCCESS;
    }

    protected function stub(string $name): string
    {
        return <<<PHP
<?php

namespace App\UseCases;

class {$name}
{
    public function execute()
    {
        //
    }
}
PHP;
    }
}
