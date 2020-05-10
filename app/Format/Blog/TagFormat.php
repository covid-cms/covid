<?php

namespace App\Format\Blog;

use App\Format\ModelFormat;
use App\Models\Blog\Tag;
use Illuminate\Database\Eloquent\Model;

class TagFormat extends ModelFormat
{
    const LILE = 'lite';
    const STANDARD = 'standard';

    public static function format($type, Model $tag, array $options = [])
    {
        if ($type == static::LILE) {
            return static::formatLite($tag);
        }

        if ($type == static::STANDARD) {
            return static::formatStd($tag);
        }
    }

    public static function formatList($tags, $type)
    {
        $formatedTags = [];
        foreach ($tags as $tag) {
            $formatedTags[] = $tag->format($type);
        }

        return $formatedTags;
    }

    protected static function formatLite(Tag $tag)
    {
        return [
            'id' => $tag->id,
            'title' => $tag->title,
        ];
    }

    protected static function formatStd(Tag $tag)
    {
        return [
            'id' => $tag->id,
            'title' => $tag->title,
            'slug' => $tag->slug,
            'meta_title' => $tag->meta_title,
            'meta_description' => $tag->meta_description,
            'description' => $tag->description,
            'thumbnail' => $tag->thumbnail,
            'public_url' => route('home.blog.tag', $tag->slug),
        ];
    }
}
