<?php

namespace App\Http\Requests\Api\Blog\Tag;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Standardizable;
use App\Http\Requests\ResponseJsonOnFail;
use Str;

class CreateRequest extends FormRequest implements Standardizable
{
    use ResponseJsonOnFail;

    public function rules()
    {
        return [
            'title' => 'required',
        ];
    }

    public function standardize()
    {
        return collect([
            'title' => filter_var(trim($this->input('title')), FILTER_SANITIZE_STRING),
            'slug' => Str::slug($this->input('slug')),
        ]);
    }
}
