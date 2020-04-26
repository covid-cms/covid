<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use App\Format\Blog\ArticleFormat;

class Article extends Model
{
    protected $table = 'blog_articles';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_article_to_category', 'article_id', 'category_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Tag::class, 'blog_article_to_tag', 'article_id', 'tag_id');
    }

    public function author()
    {
        return $this->belongsTo(App\Models\User::class, 'author_id', 'id');
    }

    public function format($type)
    {
        return ArticleFormat::format($type, $this);
    }
}
