<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Storage;
use App\Services\StorageService;

class StorageController extends Controller
{
    protected $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    public function upload(Storage\UploadRequest $request)
    {
        $path = $this->storageService->storeUploadedFile($request->file('file'));

        return response()->json([
            'error' => false,
        ]);
    }
}
