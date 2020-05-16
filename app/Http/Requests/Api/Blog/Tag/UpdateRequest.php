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
        $sluglyRegex = config('regex.slugly');
        $tag = $this->route('tag');

        return [
            'title' => 'sometimes|required',
            'slug' => "sometimes|regex:$sluglyRegex|unique:blog_tags,slug,$tag->id",
        ];
    }

    public function standardize()
    {
        $standardizedData = [];

        if ($this->has('title')) {
            $standardizedData['title'] = filter_var(trim($this->input('title')), FILTER_SANITIZE_STRING);
        }
        if ($this->has('slug')) {
            $standardizedData['slug'] = Str::slug($this->input('slug'));
        }
        if ($this->has('meta_title')) {
            $standardizedData['meta_title'] = $this->input('meta_title');
        }
        if ($this->has('meta_description')) {
            $standardizedData['meta_description'] = $this->input('meta_description');
        }
        if ($this->has('description')) {
            $standardizedData['description'] = $this->input('description');
        }
        if ($this->has('thumbnail')) {
            $standardizedData['thumbnail'] = $this->input('thumbnail');
        }

        return collect($standardizedData);
    }
}
