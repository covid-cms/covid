<?php

namespace App\Http\Requests\Api\Blog\Category;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Standardizable;
use App\Http\Requests\ResponseJsonOnFail;
use Str;
use App\Models\Blog\Category;

class UpdateRequest extends FormRequest implements Standardizable
{
    use ResponseJsonOnFail;

    public function rules()
    {
        $category = $this->route('category');

        $parentIdMustExisted = function ($attribute, $categoryId, $fail) {
            if ($categoryId) {
                $category = Category::find($categoryId);
                if (!$category) {
                    return $fail("Parent is not exists");
                }
            }
        };

        $sluglyRegex = config('regex.slugly');
        $category = $this->route('category');

        return [
            'title' => 'sometimes|required',
            'slug' => "sometimes|regex:$sluglyRegex|unique:blog_categories,slug,$category->id",
            'parent_id' => ['nullable', 'integer', $parentIdMustExisted],
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
        if ($this->has('parent_id')) {
            $standardizedData['parent_id'] = (int)$this->input('parent_id');
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
