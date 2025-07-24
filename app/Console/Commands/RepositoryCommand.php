<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to make an repository';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $directory = app_path('Contracts/Repositories');
        $filepath = $directory . '/' . $name . 'Repository.php';

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (File::exists($filepath)) {
            $this->error('Repository sudah ada!');
            return;
        }

        $stub = <<<EOT
            <?php

            namespace App\Contracts\Repositories;

            use App\Contracts\Interfaces\${$name}Interface;
            use App\Models\${$name};

            class {$name}Repository extends BaseRepository implements {$name}Interface
            {
                public function __construct({$name} \${$name})
                {
                    \$this->model = \${$name};
                }

                public function get(): mixed
                {
                    return \$this->model->query()->get();
                }

                public function store(array \$data): mixed
                {
                    return \$this->model->query()->create(\$data);
                }

                public function show(mixed \$id): mixed
                {
                    return \$this->model->query()->findOrFail(\$id);
                }

                public function update(mixed \$id, array \$data): mixed
                {
                    return \$this->model->query()->findOrFail(\$id)->update(\$data);
                }

                public function delete(mixed \$id): mixed
                {
                    return \$this->model->query()->findOrFail(\$id)->delete();
                }
                }
            EOT;

        File::put($filepath, $stub);
        $this->info("Repository {$name} berhasil dibuat! {$filepath}");
    }
}
