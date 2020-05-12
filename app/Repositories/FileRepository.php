<?php

namespace App\Repositories;

use App\Models\File;
use App\Repositories\ModelRepository;
use Storage;

class FileRepository extends ModelRepository
{
    protected function define()
    {
        $this->model = File::class;
    }

    public function findByHash($hashString)
    {
        return $this->find(['hash_string' => $hashString]);
    }
}
