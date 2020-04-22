<?php

namespace App\Services;

use Storage;
use Illuminate\Http\UploadedFile;

class StorageService
{
    public function storeUploadedFile(UploadedFile $file)
    {
        $filename = $this->genFilename($file->getClientOriginalName());
        $path = $this->genPath();

        return $file->storeAs($path, $filename);
    }

    private function genFilename($orginalFilename)
    {
        return md5(uniqid()) . $orginalFilename;
    }

    private function genPath()
    {
        $path = date('Y') . '/' . date('m');

        if (is_dir(storage_path($path))) {
            mkdir($path, 0777, true);
        }

        return $path;
    }
}
