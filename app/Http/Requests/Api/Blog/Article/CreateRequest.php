<?php

namespace App\Http\Requests\Api\Blog\Article;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Standardizable;
use App\Http\Requests\ResponseJsonOnFail;
use Str;

class CreateRequest extends FormRequest implements Standardizable
{
    use ResponseJsonOnFail;

    public function rules()
    {
        $sluglyRegex = config('regex.slugly');

        return [
            'title' => 'required',
            'slug' => "nullable|regex:$sluglyRegex|unique:blog_articles,slug",
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
            'categories.*' => 'exists:blog_categories,id',
            'tags.*' => 'exists:blog_tags,id',
            'status' => 'nullable|in:' . implode(',', config('blog.article.status')),
        ];
    }

    public function standardize()
    {
        return collect([
            'title' => filter_var(trim($this->input('title')), FILTER_SANITIZE_STRING),
            'content' => $this->input('content'),
            'thumbnail' => $this->input('thumbnail'),
            'meta_title' => $this->input('meta_title'),
            'meta_description' => $this->input('meta_description'),
            'slug' => Str::slug($this->input('slug')),
            'categories' => $this->input('categories'),
            'tags' => $this->input('tags'),
            'status' => $this->input('status'),
        ]);
    }
}
