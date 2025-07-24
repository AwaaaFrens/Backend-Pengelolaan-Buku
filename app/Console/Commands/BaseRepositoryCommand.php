<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BaseRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:baserepo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command make a BaseRepository';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = app_path('Contracts/Repositories');
        $filepath = $directory . '/' . 'BaseRepository.php';

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (File::exists($filepath)) {
            $this->error('Repository sudah ada!');
            return;
        }

        $content = <<<PHP
        <?php

        namespace App\Contracts\Repositories;

        use Illuminate\Database\Eloquent\Model;

        abstract class BaseRepository
        {
            /**
            * Handle model initialization.
            *
            * @var Model \$model
            */
            public Model \$model;
        }

        PHP;

        File::put($filepath, $content);
        $this->info("BaseRepository.php berhasil dibuat $filepath");
        return Command::SUCCESS;
    }
}
