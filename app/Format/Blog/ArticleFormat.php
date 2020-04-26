<?php

namespace App\Format\Blog;

use App\Format\ModelFormat;
use App\Models\Blog\Article;
use Illuminate\Database\Eloquent\Model;

class ArticleFormat extends ModelFormat
{
    const LILE = 'lite';
    const STANDARD = 'standard';

    public static function format($type, Model $article, array $options = [])
    {
        if ($type == static::LILE) {
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
        ];
    }
}
