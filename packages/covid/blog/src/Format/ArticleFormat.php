<?php

namespace Covid\Blog\Format;

use Covid\Framework\Model\Format;
use Covid\Base\Format\UserFormat;
use Covid\Blog\Models\Article;
use Covid\Blog\Format\CategoryFormat;
use Covid\Blog\Format\TagFormat;
use Illuminate\Database\Eloquent\Model;

class ArticleFormat extends Format
{
    const LITE = 'lite';
    const STANDARD = 'standard';
    const DETAIL = 'detail';

    public static function format($type, Model $article, array $options = [])
    {
        if ($type == static::LITE) {
            return static::formatLite($article);
        }

        if ($type == static::STANDARD) {
            return static::formatStd($article);
        }

        if ($type == static::DETAIL) {
            return static::formatDetail($article);
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
            'publish_at' => $article->publish_at ? $article->publish_at->format('Y-m-d H:i:s') : null,
            'created_at' => $article->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $article->updated_at->format('Y-m-d H:i:s'),
            'public_url' => route('home.blog.article', $article->slug),
        ];
    }

    protected static function formatDetail(Article $article)
    {
        return [
            'id' => $article->id,
            'title' => $article->title,
            'content' => $article->content,
            'slug' => $article->slug,
            'meta_title' => $article->meta_title,
            'meta_description' => $article->meta_description,
            'thumbnail' => $article->thumbnail,
            'status' => $article->status,
            'categories' => CategoryFormat::formatList($article->categories, CategoryFormat::STANDARD),
            'tags' => TagFormat::formatList($article->tags, TagFormat::STANDARD),
            'author' => $article->author->format(UserFormat::LITE),
            'publish_at' => $article->publish_at ? $article->publish_at->format('Y-m-d H:i:s') : null,
            'created_at' => $article->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $article->updated_at->format('Y-m-d H:i:s'),
            'public_url' => route('home.blog.article', $article->slug),
        ];
    }
}
