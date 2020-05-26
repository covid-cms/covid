<?php

namespace Covid\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Covid\Framework\Model\Formattable;
use Covid\Blog\Format\TagFormat;

class Tag extends Model implements Formattable
{
    protected $table = 'blog_tags';

    protected $primaryKey = 'id';

    protected $guarded = [
        'id', 'created_at', 'updated_at',
    ];

    public function format($type)
    {
        return TagFormat::format($type, $this);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'blog_article_to_tag', 'tag_id', 'article_id');
    }
}
