<?php

namespace App\Repositories\Blog;

use App\Models\Blog\Arcile;
use App\Repositories\ModelRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Str;

class ArcileRepository extends ModelRepository
{
    protected function define()
    {
        $this->model = Arcile::class;
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

        $article = Arcile::create([
            'title' => $data['title'],
            'slug' => $data['slug'],
        ]);

        return $article;
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

    public function update(Model $article, array $data)
    {
        $this->valiateUpdateData($data);

        if (!empty($data['title'])) {
            $article->title = $data['title'];
        }

        if (!empty($data['slug'])) {
            $article->slug = $data['slug'];
        } elseif (isset($data['slug']) && empty($data['slug'])) {
            $article->slug = Str::slug($data['slug']);
        }

        return $article->save();
    }
}
