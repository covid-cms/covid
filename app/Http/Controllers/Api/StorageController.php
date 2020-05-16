<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Storage;
use App\Services\StorageService;
use App\Format\FileFormat;

class StorageController extends Controller
{
    protected $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    public function upload(Storage\UploadRequest $request)
    {
        $uploadedFile = $this->storageService->storeUploadedFile($request->file('upload'));

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
