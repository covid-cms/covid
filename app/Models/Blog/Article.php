<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'blog_articles';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_article_to_category', 'article_id', 'category_id');
    }
}
