<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Validator;
use App\Models\User;
use App\Repositories\UserRepository;
use Hash;

class CreateUserCommand extends Command
{
    protected $signature = 'user:create';
    protected $description = 'Create user';
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        parent::__construct();

        $this->userRepo = $userRepo;
    }

    public function handle()
    {
        $email = $this->ask('What is your email?');
        $password = $this->secret('What is the password?');
        $name = $this->ask('What is your name?');
        $data = compact('email', 'password', 'name');

        $validator = $this->validate($data);

        if ($validator->fails()) {
            foreach ($validator->errors() as $error) {
                $this->error($error);
            }
            return;
        }

        $this->userRepo->create([
            'email' => $email,
            'password' => Hash::make($password),
            'name' => $name,
        ]);

        $this->info('User created successfully.');
    }

    protected function validate(array $data)
    {
        return Validator::make($data, [
            'email' => 'email|unique:users,email'
        ]);
    }
}
