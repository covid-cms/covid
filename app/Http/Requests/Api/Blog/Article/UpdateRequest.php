<?php

namespace App\Http\Requests\Api\Blog\Article;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Standardizable;
use App\Http\Requests\ResponseJsonOnFail;
use Str;

class UpdateRequest extends FormRequest implements Standardizable
{
    use ResponseJsonOnFail;

    public function rules()
    {
        $article = $this->route('article');
        $sluglyRegex = config('regex.slugly');

        return [
            'title' => 'sometimes|required',
            'slug' => "sometimes|required|regex:$sluglyRegex|unique:blog_articles,slug,$article->id",
            'content' => 'nullable',
            'categories' => 'sometimes|nullable|array',
            'categories.*' => 'sometimes|required|exists:blog_categories,id',
            'tags' => 'sometimes|nullable|array',
            'tags.*' => 'sometimes|required|exists:blog_tags,id',
            'status' => 'sometimes|in:' . implode(',', config('blog.article.status')),
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
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
        if ($this->has('content')) {
            $standardizedData['content'] = $this->input('content');
        }
        if ($this->has('thumbnail')) {
            $standardizedData['thumbnail'] = $this->input('thumbnail');
        }
        if ($this->has('meta_title')) {
            $standardizedData['meta_title'] = $this->input('meta_title');
        }
        if ($this->has('meta_description')) {
            $standardizedData['meta_description'] = $this->input('meta_description');
        }
        if ($this->has('categories')) {
            $standardizedData['categories'] = $this->input('categories');
        }
        if ($this->has('tags')) {
            $standardizedData['tags'] = $this->input('tags');
        }
        if ($this->has('status')) {
            $standardizedData['status'] = $this->input('status');
        }

        return collect($standardizedData);
    }
}
