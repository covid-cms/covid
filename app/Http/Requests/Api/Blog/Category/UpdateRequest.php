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

        return [
            'title' => 'sometimes|required',
            'slug' => 'sometimes|required',
            'parent_id' => ['nullable','integer', $parentIdMustExisted],
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

        if ($this->filled('parent_id')) {
            $standardizedData['parent_id'] = (int)$this->input('parent_id');
        }

        return collect($standardizedData);
    }
}
