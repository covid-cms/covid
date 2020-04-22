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

        $validator = Validator::make($data, [
            'slug' => "nullable|regex:$sluglyRegex"
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function create(array $data)
    {
        $this->validateCreateData($data);

        if (!empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }

        $category = Category::create([
            'title' => $data['title'],
            'slug' => $data['slug']
        ]);
    }
}
