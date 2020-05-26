<?php

namespace Covid\Blog\Format;

use Covid\Framework\Model\Format;
use Covid\Blog\Models\Tag;
use Illuminate\Database\Eloquent\Model;

class TagFormat extends Format
{
    const LITE = 'lite';
    const STANDARD = 'standard';
    const DETAIL = 'detail';

    public static function format($type, Model $tag, array $options = [])
    {
        if ($type == static::LITE) {
            return static::formatLite($tag);
        }

        if ($type == static::STANDARD) {
            return static::formatStd($tag);
        }

        if ($type == static::DETAIL) {
            return static::formatDetail($tag);
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
            'articles_count' => $tag->articles_count,
            'slug' => $tag->slug,
            'meta_title' => $tag->meta_title,
            'meta_description' => $tag->meta_description,
            'description' => $tag->description,
            'thumbnail' => $tag->thumbnail,
            'public_url' => route('home.blog.tag', $tag->slug),
        ];
    }

    protected static function formatDetail(Tag $tag)
    {
        return array_merge($tag->toArray(), [
            'public_url' => route('home.blog.tag', ['slug' => $tag->slug])
        ]);
    }
}
