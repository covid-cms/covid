<?php

namespace App\Repositories\Blog;

use App\Models\Blog\Article;
use App\Repositories\ModelRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Str;

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
                $categoryQuery->whereIn('id', $options['categories']);
            });
        } elseif (!empty($options['category_id'])) {
            $query->whereHas('categories', function ($categoryQuery) use ($options) {
                $categoryQuery->where('id', $options['category_id']);
            });
        }

        if (!empty($options['tags'])) {
            $query->whereHas('tags', function ($categoryQuery) use ($options) {
                $categoryQuery->whereIn('id', $options['tags']);
            });
        } elseif (!empty($options['tag_id'])) {
            $query->whereHas('tags', function ($categoryQuery) use ($options) {
                $categoryQuery->where('id', $options['tag_id']);
            });
        }

        if (!empty($options['keyword'])) {
            $query->where('keyword', ltrim($options['keyword'], '%') . '%');
        }

        if (!empty($options['author_id'])) {
            $query->where('author_id', $options['author_id']);
        }

        if (!empty($options['slug'])) {
            $query->where('slug', $options['slug']);
        }

        return $query;
    }
}
