<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'app:install';

    protected $description = 'Install';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->call('migrate');
        $this->call('passport:install', ['--force' => true]);
        $this->call('user:create');
    }
}
