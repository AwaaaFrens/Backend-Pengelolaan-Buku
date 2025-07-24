<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class EloquentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:eloquent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to make an Eloquent';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = app_path('Contracts/Interfaces/Eloquent');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
            $this->info('Folder Eloquent berhasil dibuat');
            return;
        }

        $interfaces = [
            'GetInterface',
            'StoreInterface',
            'UpdateInterface',
            'ShowInterface',
            'DeleteInterface',
        ];

        foreach ($interfaces as $interface) {
            $filepath = "$directory/$interface.php";

            if (!File::exists($filepath)) {
                File::put($filepath, $this->generateInterface($interface));
                $this->info("Berhasil membuat: $interface");
            } else {
                $this->warn("Dilewati (telah ada): $interface");
            }
        }

        $this->info('Eloquent Interface berhasil dibuat');
    }

    public function generateInterface($interface)
    {
        $method = match ($interface) {
            'GetInterface' => 'public function get(): mixed;',
            'StoreInterface' => 'public function store(array $data): mixed;',
            'UpdateInterface' => 'public function update(mixed $id, array $data): mixed;',
            'ShowInterface' => 'public function show(mixed $id): mixed;',
            'DeleteInterface' => 'public function delete(mixed $id): mixed;',
            default => '',
        };

        return <<<PHP
        <?php

        namespace App\Contracts\Interfaces\Eloquent;

        interface $interface
        {
            $method
        }

        PHP;
    }
}
