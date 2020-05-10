<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\ModelRepository;

class UserRepository extends ModelRepository
{
    protected function define()
    {
        $this->model = User::class;
    }
}
