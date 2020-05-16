<?php

namespace App\Http\Requests\Api\Blog\Category;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Standardizable;
use App\Http\Requests\ResponseJsonOnFail;
use Str;
use App\Models\Blog\Category;

class CreateRequest extends FormRequest implements Standardizable
{
    use ResponseJsonOnFail;

    public function rules()
    {
        $parentIdMustExisted = function ($attribute, $categoryId, $fail) {
            if ($categoryId) {
                $category = Category::find($categoryId);
                if (!$category) {
                    return $fail("Parent is not exists");
                }
            }
        };

        $sluglyRegex = config('regex.slugly');

        return [
            'title' => 'required',
            'parent_id' => ['nullable', 'integer', $parentIdMustExisted],
            'slug' => "nullable|regex:$sluglyRegex|unique:blog_categories,slug",
        ];
    }

    public function standardize()
    {
        return collect([
            'title' => filter_var(trim($this->input('title')), FILTER_SANITIZE_STRING),
            'slug' => Str::slug($this->input('slug')),
            'parent_id' => (int)$this->input('parent_id'),
            'meta_title' => $this->input('meta_title'),
            'meta_description' => $this->input('meta_description'),
            'description' => $this->input('description'),
            'thumbnail' => $this->input('thumbnail'),
        ]);
    }
}
