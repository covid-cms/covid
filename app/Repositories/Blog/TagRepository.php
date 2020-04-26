<?php

namespace App\Repositories\Blog;

use App\Models\Blog\Tag;
use App\Repositories\ModelRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Str;

class TagRepository extends ModelRepository
{
    protected function define()
    {
        $this->model = Tag::class;
    }

    protected function validateCreateData(array $data)
    {
        $sluglyRegex = config('regex.slugly');

        $validator = Validator::make($data, [
            'title' => 'required',
            'slug' => "nullable|regex:$sluglyRegex",
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

        $category = Tag::create([
            'title' => $data['title'],
            'slug' => $data['slug'],
        ]);

        return $category;
    }

    protected function valiateUpdateData(array $data)
    {
        $sluglyRegex = config('regex.slugly');

        $validator = Validator::make($data, [
            'title' => 'sometimes|required',
            'slug' => "nullable|regex:$sluglyRegex",
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

        return $category->save();
    }
}
