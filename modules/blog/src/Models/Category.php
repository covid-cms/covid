<?php

namespace Covid\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Covid\Framework\Model\Formattable;
use Covid\Blog\Format\CategoryFormat;

class Category extends Model implements Formattable
{
    protected $table = 'blog_categories';

    protected $primaryKey = 'id';

    protected $guarded = [
        'id', 'created_at', 'updated_at',
    ];

    public function format($type)
    {
        return CategoryFormat::format($type, $this);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'blog_article_to_category', 'category_id', 'article_id');
    }
}
