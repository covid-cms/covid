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
            // 'urls' => [
            //     'default' => 'https://i.picsum.photos/id/126/536/354.jpg',
            //     '800' => 'https://i.picsum.photos/id/126/800/800.jpg',
            //     '1024' => 'https://i.picsum.photos/id/126/1024/1024.jpg',
            //     '1920' => 'https://i.picsum.photos/id/126/1920/1920.jpg'
            // ],
            // 'data' => [
            //     'uploaded_file' => $uploadedFile->format(FileFormat::STANDARD),
            // ]
        ]);
    }
}
