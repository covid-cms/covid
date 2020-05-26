<?php

namespace Covid\Blog\Format;

use Covid\Framework\Model\Format;
use Covid\Blog\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryFormat extends Format
{
    const LITE = 'lite';
    const STANDARD = 'standard';
    const DETAIL = 'detail';

    public static function format($type, Model $category, array $options = [])
    {
        if ($type == static::LITE) {
            return static::formatLite($category);
        }

        if ($type == static::STANDARD) {
            return static::formatStd($category);
        }

        if ($type == static::DETAIL) {
            return static::formatDetail($category);
        }
    }

    public static function formatList($categories, $type)
    {
        $formatedCategories = [];
        foreach ($categories as $category) {
            $formatedCategories[] = $category->format($type);
        }

        return $formatedCategories;
    }

    protected static function formatLite(Category $category)
    {
        return [
            'id' => $category->id,
            'title' => $category->title,
        ];
    }

    protected static function formatStd(Category $category)
    {
        return [
            'id' => $category->id,
            'title' => $category->title,
            'articles_count' => $category->articles_count,
            'slug' => $category->slug,
            'parent_id' => $category->parent_id,
            'meta_title' => $category->meta_title,
            'meta_description' => $category->meta_description,
            'description' => $category->description,
            'thumbnail' => $category->thumbnail,
            'public_url' => route('home.blog.category', ['slug' => $category->slug])
        ];
    }

    protected static function formatDetail(Category $category)
    {
        return array_merge($category->toArray(), [
            'public_url' => route('home.blog.category', ['slug' => $category->slug])
        ]);
    }
}
