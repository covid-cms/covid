<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use App\Models\Formattable;
use App\Format\Blog\TagFormat;

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
