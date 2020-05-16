<?php

namespace App\Repositories\Blog;

use App\Models\Blog\Category;
use App\Repositories\ModelRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Str;

class CategoryRepository extends ModelRepository
{
    protected function define()
    {
        $this->model = Category::class;
    }

    protected function validateCreateData(array $data)
    {
        $categoryParentMustExisted = function ($attribute, $categoryId, $fail) {
            if ($categoryId) {
                $existedCategory = Category::find($categoryId);
                if (!$existedCategory) {
                    return $fail('Parent is not exists');
                }
            }
        };

        $sluglyRegex = config('regex.slugly');

        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $validator = Validator::make($data, [
            'title' => 'required',
            'slug' => "required|regex:$sluglyRegex|unique:blog_categories,slug",
            'parent_id' => ['nullable', 'integer', $categoryParentMustExisted]
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function create(array $data)
    {
        $this->validateCreateData($data);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (!empty($data['parent_id'])) {
            $data['parent_id'] = $data['parent_id'];
        }

        $category = Category::create($data);

        return $category;
    }

    protected function validateUpdateData(Category $category, array $data)
    {
        $sluglyRegex = config('regex.slugly');
        $categoryParentMustExisted = function ($attribute, $categoryId, $fail) {
            if ($categoryId) {
                $existedCategory = Category::find($categoryId);
                if (!$existedCategory) {
                    return $fail('Parent is not exists');
                }
            }
        };

        $validator = Validator::make($data, [
            'title' => 'sometimes|required',
            'slug' => "sometimes|regex:$sluglyRegex|unique:blog_categories,slug,$category->id",
            'parent_id' => ['nullable', 'integer', $categoryParentMustExisted],
            'meta_title' => 'sometimes|nullable',
            'meta_description' => 'sometimes|nullable',
            'description' => 'sometimes|nullable',
            'thumbnail' => 'sometimes|nullable',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function update(Model $category, array $data)
    {
        $this->validateUpdateData($category, $data);

        if (!empty($data['title'])) {
            $category->title = $data['title'];
        }

        if (!empty($data['slug'])) {
            $category->slug = $data['slug'];
        } elseif (isset($data['slug']) && empty($data['slug'])) {
            $category->slug = Str::slug($data['slug']);
        }

        if (isset($data['parent_id'])) {
            $category->parent_id = $data['parent_id'];
        }

        if (array_key_exists('meta_title', $data)) {
            $category->meta_title = $data['meta_title'];
        }

        if (array_key_exists('meta_description', $data)) {
            $category->meta_description = $data['meta_description'];
        }

        if (array_key_exists('thumbnail', $data)) {
            $category->thumbnail = $data['thumbnail'];
        }

        if (array_key_exists('description', $data)) {
            $category->description = $data['description'];
        }

        return $category->save();
    }

    public function delete(Model $category)
    {
        Category::where('parent_id', $category->id)->update(['parent_id' => 0]);

        return parent::delete($category);
    }
}
