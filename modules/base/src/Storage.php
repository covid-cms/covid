<?php

namespace Covid\Base;

use Storage as LaravelStorage;
use Illuminate\Http\UploadedFile;
use Covid\Base\File as FileRepository;

class Storage
{
    protected $fileRepo;
    protected $disk = null;

    public function __construct(FileRepository $fileRepo)
    {
        $this->fileRepo = $fileRepo;
        $this->disk = 'public';
    }

    protected function storage()
    {
        return LaravelStorage::disk($this->disk);
    }

    public function storeUploadedFile(UploadedFile $file)
    {
        $fileHashString = md5_file($file->getRealPath());
        $uploadedFile = $this->fileRepo->findByHash($fileHashString);

        if (!$uploadedFile) {
            $filename = $this->genFilename($file->getClientOriginalName());
            $path = $this->genPath();

            $this->storage()->putFileAs($path, $file, $filename);

            $uploadedFile = $this->fileRepo->create([
                'hash_string' => $fileHashString,
                'path' => $path . '/' . $filename
            ]);
        }

        return $uploadedFile;
    }

    private function genFilename($orginalFilename)
    {
        return md5(uniqid()) . $orginalFilename;
    }

    private function genPath()
    {
        $path = 'uploads/' . date('Y') . '/' . date('m');

        if (is_dir(storage_path($path))) {
            mkdir($path, 0777, true);
        }

        return $path;
    }
}
