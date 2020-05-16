<?php

namespace App\Repositories\Blog;

use App\Models\Blog\Article;
use App\Repositories\ModelRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Str;
use Arr;

class ArticleRepository extends ModelRepository
{
    protected function define()
    {
        $this->model = Article::class;
    }

    public function query(array $options = [])
    {
        $query = parent::query();

        if (isset($options['status']) && $options['status'] != Article::STATUS_ALL) {
            $query->where('status', $options['status']);
        }

        if (!empty($options['categories'])) {
            $query->whereHas('categories', function ($categoryQuery) use ($options) {
                $categoryQuery->whereIn('blog_categories.id', $options['categories']);
            });
        } elseif (!empty($options['category_id'])) {
            $query->whereHas('categories', function ($categoryQuery) use ($options) {
                $categoryQuery->where('blog_categories.id', $options['category_id']);
            });
        }

        if (!empty($options['tags'])) {
            $query->whereHas('tags', function ($categoryQuery) use ($options) {
                $categoryQuery->whereIn('blog_tags.id', $options['tags']);
            });
        } elseif (!empty($options['tag_id'])) {
            $query->whereHas('tags', function ($categoryQuery) use ($options) {
                $categoryQuery->where('blog_tags.id', $options['tag_id']);
            });
        }

        if (!empty($options['keyword'])) {
            $query->where('title', 'like', '%' . trim($options['keyword'], '%') . '%');
        }

        if (!empty($options['author_id'])) {
            $query->where('author_id', $options['author_id']);
        }

        if (!empty($options['slug'])) {
            $query->where('slug', $options['slug']);
        }

        return $query;
    }

    protected function validateCreateData(array $data)
    {
        $availableStatus = config('blog.article.status');
        $sluglyRegex = config('regex.slugly');

        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $validator = Validator::make($data, [
            'title' => 'required',
            'slug' => "required|regex:$sluglyRegex|unique:blog_articles,slug",
            'content' => 'nullable',
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
            'categories.*' => 'exists:blog_categories,id',
            'tags.*' => 'exists:blog_tags,id',
            'author_id' => 'exists:users,id',
            'status' => 'nullable|in:' . implode(',', $availableStatus),
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    protected function validateUpdateData(Article $article, $data)
    {
        $availableStatus = config('blog.article.status');
        $sluglyRegex = config('regex.slugly');

        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $validator = Validator::make($data, [
            'title' => 'sometimes|required',
            'slug' => "sometimes|required|regex:$sluglyRegex|unique:blog_articles,slug,$article->id",
            'content' => 'sometimes|nullable',
            'categories' => 'sometimes|nullable|array',
            'categories.*' => 'sometimes|exists:blog_categories,id',
            'tags' => 'sometimes|nullable|array',
            'tags.*' => 'sometimes|exists:blog_tags,id',
            'author_id' => 'sometimes|exists:users,id',
            'status' => 'sometimes|nullable|in:' . implode(',', $availableStatus),
            'meta_title' => 'sometimes|nullable',
            'meta_description' => 'sometimes|nullable',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function create(array $data)
    {
        $this->validateCreateData($data);

        if (empty($data['status'])) {
            $data['status'] = Article::STATUS_PUBLISHED;
        }

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $article = Article::create(Arr::except($data, ['tags', 'categories']));

        if (!empty($data['tags'])) {
            $article->tags()->sync($data['tags']);
        }

        if (!empty($data['categories'])) {
            $article->categories()->sync($data['categories']);
        }

        return $article;
    }

    public function update(Model $article, array $data)
    {
        $this->validateUpdateData($article, $data);
        if (!empty($data['title'])) {
            $article->title = $data['title'];
        }

        if (!empty($data['slug'])) {
            $article->slug = Str::slug($data['slug']);
        }

        if (array_key_exists('content', $data)) {
            $article->content = $data['content'];
        }

        if (array_key_exists('author_id', $data)) {
            $article->author_id = $data['author_id'];
        }

        if (array_key_exists('status', $data)) {
            $article->status = $data['status'];
        }

        if (array_key_exists('meta_title', $data)) {
            $article->meta_title = $data['meta_title'];
        }

        if (array_key_exists('meta_description', $data)) {
            $article->meta_description = $data['meta_description'];
        }

        if (array_key_exists('thumbnail', $data)) {
            $article->thumbnail = $data['thumbnail'];
        }

        if (array_key_exists('tags', $data)) {
            $article->tags()->detach();
            $article->tags()->sync($data['tags']);
        }

        if (array_key_exists('categories', $data)) {
            $article->categories()->detach();
            $article->categories()->sync($data['categories']);
        }

        return $article->save();
    }
}
