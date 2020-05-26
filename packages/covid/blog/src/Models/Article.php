<?php

namespace Covid\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Covid\Framework\Model\Formattable;
use Covid\Blog\Format\ArticleFormat;

class Article extends Model implements Formattable
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
        $authorModelPath = config('blog.author_model', \Covid\Base\Models\User::class);
        return $this->belongsTo($authorModelPath, 'author_id', 'id');
    }

    public function format($type)
    {
        return ArticleFormat::format($type, $this);
    }
}
