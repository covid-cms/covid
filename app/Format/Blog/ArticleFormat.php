<?php

namespace App\Format\Blog;

use App\Format\ModelFormat;
use App\Models\Blog\Article;
use Illuminate\Database\Eloquent\Model;
use App\Format\Blog\CategoryFormat;
use App\Format\UserFormat;
use App\Format\Blog\TagFormat;

class ArticleFormat extends ModelFormat
{
    const LITE = 'lite';
    const STANDARD = 'standard';

    public static function format($type, Model $article, array $options = [])
    {
        if ($type == static::LITE) {
            return static::formatLite($article);
        }

        if ($type == static::STANDARD) {
            return static::formatStd($article);
        }
    }

    public static function formatList($articles, $type)
    {
        $formatedArticles = [];
        foreach ($articles as $article) {
            $formatedArticles[] = $article->format($type);
        }

        return $formatedArticles;
    }

    public static function formatPaginate($paginatedArticles, $type)
    {
        $articles = $paginatedArticles->items();
        foreach ($articles as &$article) {
            $article = $article->format($type);
        }

        return array_merge($paginatedArticles->toArray(), [
            'data' => $articles,
        ]);
    }

    protected static function formatLite(Article $article)
    {
        return [
            'id' => $article->id,
            'title' => $article->title,
        ];
    }

    protected static function formatStd(Article $article)
    {
        return [
            'id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
            'meta_title' => $article->meta_title,
            'meta_description' => $article->meta_description,
            'thumbnail' => $article->thumbnail,
            'status' => $article->status,
            'categories' => CategoryFormat::formatList($article->categories, CategoryFormat::STANDARD),
            'tags' => TagFormat::formatList($article->tags, TagFormat::STANDARD),
            'author' => $article->author->format(UserFormat::LITE),
            'publish_at' => $article->publish_at->format('Y-m-d H:i:s'),
            'created_at' => $article->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $article->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
