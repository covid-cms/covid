<?php

namespace App\Repositories\Blog;

use App\Models\Blog\Category;
use App\Repositories\ModelRepository;
use Illuminate\Validation\ValidationException;
use Validator;

class CategoryRepository extends ModelRepository
{
    protected function define()
    {
        $this->model = Category::class;
    }

    protected function validateCreateData($data)
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
            $data['slug'] = \Str::slug($data['title']);
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
}
