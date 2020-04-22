<?php

namespace App\Format\Blog;

use App\Format\ModelFormat;
use App\Models\Blog\Category;

class CategoryFormat extends ModelFormat
{
    const LILE = 'lite';
    const STANDARD = 'standard';

    public static function make($type, Category $category, array $options = [])
    {
        if ($type == static::LILE) {
            return static::formatLite($category);
        }

        if ($type == static::STANDARD) {
            return static::formatStd($category);
        }
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
            'slug' => $category->slug,
            'parent_id' => $category->parent_id,
        ];
    }
}

