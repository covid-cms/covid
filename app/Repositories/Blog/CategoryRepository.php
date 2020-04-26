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
            'title' => 'required',
            'slug' => "nullable|regex:$sluglyRegex",
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
            $data['parent_id'] = 0;
        }

        $category = Category::create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'parent_id' => $data['parent_id']
        ]);

        return $category;
    }

    protected function valiateUpdateData(array $data)
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
            'slug' => "nullable|regex:$sluglyRegex",
            'parent_id' => ['nullable', 'integer', $categoryParentMustExisted]
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function update(Model $category, array $data)
    {
        $this->valiateUpdateData($data);

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

        return $category->save();
    }
}
