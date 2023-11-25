<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateStorageLink extends Command
{
    protected $signature = 'storage:link-check';
    protected $description = 'Create the symbolic link for storage if it does not exist';

    public function handle()
    {
        if (!file_exists(public_path('storage'))) {
            $this->call('storage:link');
            $this->info('The [public/storage] link has been created.');
        } else {
            $this->info('The [public/storage] link already exists.');
        }
    }
}
