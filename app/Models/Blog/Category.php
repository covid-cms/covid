<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use App\Models\Formattable;
use App\Format\Blog\CategoryFormat;

class Category extends Model implements Formattable
{
    protected $table = 'blog_categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title', 'slug', 'parent_id'
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
