<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use App\Format\Blog\ArticleFormat;
use App\Models\User;

class Article extends Model
{
    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';
    const STATUS_ALL = 'all';

    protected $table = 'blog_articles';

    protected $primaryKey = 'id';

    protected $guarded = [
        'id', 'created_at', 'updated_at',
    ];

    protected $dates = [
        'publish_at'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_article_to_category', 'article_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_article_to_tag', 'article_id', 'tag_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function format($type)
    {
        return ArticleFormat::format($type, $this);
    }
}
