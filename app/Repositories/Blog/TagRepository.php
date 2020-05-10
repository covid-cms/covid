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

        $tag = Tag::create($data);

        return $tag;
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

    public function update(Model $tag, array $data)
    {
        $this->valiateUpdateData($data);

        if (!empty($data['title'])) {
            $tag->title = $data['title'];
        }

        if (!empty($data['slug'])) {
            $tag->slug = $data['slug'];
        } elseif (isset($data['slug']) && empty($data['slug'])) {
            $tag->slug = Str::slug($data['slug']);
        }

        if (isset($data['meta_title'])) {
            $tag->meta_title = $data['meta_title'];
        }

        if (isset($data['meta_description'])) {
            $tag->meta_description = $data['meta_description'];
        }

        if (isset($data['thumbnail'])) {
            $tag->thumbnail = $data['thumbnail'];
        }

        if (isset($data['description'])) {
            $tag->description = $data['description'];
        }

        return $tag->save();
    }
}
