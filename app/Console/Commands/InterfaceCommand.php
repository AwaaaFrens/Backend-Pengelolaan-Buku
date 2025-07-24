<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InterfaceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to make an interface';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $directory = app_path('Contracts/Interfaces');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
            $this->info('Directory berhasil dibuat!');
            return;
        }

        $filepath = $directory . '/' . $name . 'Interface.php';

        if (File::exists($filepath)) {
            $this->error('Interface sudah ada!');
            return;
        }

        $interfaceContent = "<?php
        \nnamespace App\Contracts\Interfaces;
        \nuse App\Contracts\Interfaces\Eloquent\DeleteInterface; \nuse App\Contracts\Interfaces\Eloquent\GetInterface; \nuse App\Contracts\Interfaces\Eloquent\ShowInterface; \nuse App\Contracts\Interfaces\Eloquent\StoreInterface; \nuse App\Contracts\Interfaces\Eloquent\UpdateInterface;
        \ninterface {$name}Interface extends GetInterface, StoreInterface, UpdateInterface, ShowInterface, DeleteInterface \n{\n    // Define your methods here\n}";

        File::put($filepath, $interfaceContent);
        $absolutPath = realpath($filepath);
        $this->info("Interface [{$absolutPath}] berhasil dibuat!");
    }
}
