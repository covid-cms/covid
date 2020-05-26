<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Storage as StorageRequest;
use Covid\Base\Storage;
use Covid\Base\Format\FileFormat;

class StorageController extends Controller
{
    protected $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function upload(StorageRequest\UploadRequest $request)
    {
        $uploadedFile = $this->storage->storeUploadedFile($request->file('upload'));

        return response()->json([
            'error' => false,
            'url' => url('storage/' . $uploadedFile->path),
            'urls' => [
                'default' => url('storage/' . $uploadedFile->path),
                '150' => url('resizes/thumbnail/storage/' . $uploadedFile->path),
                '600' => url('resizes/medium/storage/' . $uploadedFile->path),
                '800' => url('resizes/larage/storage/' . $uploadedFile->path),
            ],
        ]);
    }
}
