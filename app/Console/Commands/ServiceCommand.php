<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to make a Service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $directory = app_path('Services');
        $filepath = $directory . '/' . $name . 'Service.php';

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
            $this->info('Folder Service berhasil dibuat');
            return;
        }

        if (File::exists($filepath)) {
            $this->error('Service sudah ada!');
            return;
        }

        $content = <<<PHP
            <?php

            namespace App\Services;

            class {$name}Service
            {
                //
            }

            PHP;

        File::put($filepath, $content);
        $this->info("{$name}Service berhasil dibuat!");
        return Command::SUCCESS;
    }
}
