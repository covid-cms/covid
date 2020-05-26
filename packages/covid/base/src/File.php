<?php

namespace Covid\Base;

use Covid\Base\Models\File as FileModel;
use Covid\Framework\Model\Repository;
use Storage;

class File extends Repository
{
    protected function define()
    {
        $this->model = FileModel::class;
    }

    public function findByHash($hashString)
    {
        return $this->find(['hash_string' => $hashString]);
    }
}
