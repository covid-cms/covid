<?php

namespace App\Http\Requests\Api\Blog\Tag;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Standardizable;
use App\Http\Requests\ResponseJsonOnFail;
use Str;

class UpdateRequest extends FormRequest implements Standardizable
{
    use ResponseJsonOnFail;

    public function rules()
    {
        return [
            'title' => 'sometimes|required',
            'slug' => 'sometimes|required',
        ];
    }

    public function standardize()
    {
        $standardizedData = [];

        if ($this->filled('title')) {
            $standardizedData['title'] = filter_var(trim($this->input('title')), FILTER_SANITIZE_STRING);
        }

        if ($this->filled('slug')) {
            $standardizedData['slug'] = Str::slug($this->input('slug'));
        }

        return collect($standardizedData);
    }
}
