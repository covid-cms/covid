<?php

namespace App\Http\Requests\Api\Storage;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ResponseJsonOnFail;

class UploadRequest extends FormRequest
{
    use ResponseJsonOnFail;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $maxUploadSize = config('storage.max_upload_size');

        return [
            'upload' => ['image', 'required', "max:$maxUploadSize"]
        ];
    }
}
