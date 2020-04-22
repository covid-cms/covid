<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use App\Models\Formattable;
use App\Format\Blog\Category as CategoryFormat;

class Category extends Model implements Formattable
{
    protected $table = 'blog_categories';

    protected $primaryKey = 'id';

    public function format($type)
    {
        return CategoryFormat::format($type, $this);
    }
}
