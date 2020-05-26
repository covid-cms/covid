<?php

namespace Covid\Blog;

use Covid\Blog\Models\Tag as TagModel;
use Covid\Framework\Model\Repository;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Str;
use Arr;

class Tag extends Repository
{
    protected function define()
    {
        $this->model = TagModel::class;
    }

    protected function validateCreateData(array $data)
    {
        $sluglyRegex = config('regex.slugly');

        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $validator = Validator::make($data, [
            'title' => 'required|unique:blog_tags',
            'slug' => "required|regex:$sluglyRegex|unique:blog_tags,slug",
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
        $tag = TagModel::create($data);

        return $tag;
    }

    protected function validateUpdateData(TagModel $tag, array $data)
    {
        $sluglyRegex = config('regex.slugly');

        $validator = Validator::make($data, [
            'title' => 'sometimes|required',
            'slug' => "sometimes|regex:$sluglyRegex|unique:blog_tags,slug,$tag->id",
            'meta_title' => 'sometimes|nullable',
            'meta_description' => 'sometimes|nullable',
            'description' => 'sometimes|nullable',
            'thumbnail' => 'sometimes|nullable',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function update(Model $tag, array $data)
    {
        $this->validateUpdateData($tag, $data);

        if (!empty($data['title'])) {
            $tag->title = $data['title'];
        }

        if (!empty($data['slug'])) {
            $tag->slug = $data['slug'];
        } elseif (isset($data['slug']) && empty($data['slug'])) {
            $tag->slug = Str::slug($data['slug']);
        }

        if (array_key_exists('meta_title', $data)) {
            $tag->meta_title = $data['meta_title'];
        }

        if (array_key_exists('meta_description', $data)) {
            $tag->meta_description = $data['meta_description'];
        }

        if (array_key_exists('thumbnail', $data)) {
            $tag->thumbnail = $data['thumbnail'];
        }

        if (array_key_exists('description', $data)) {
            $tag->description = $data['description'];
        }

        return $tag->save();
    }
}
