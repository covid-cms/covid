<?php

namespace App\Http\Controllers\Home\Blog;

use App\Repositories\Blog\ArticleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog\Article;

class ArticleController extends Controller
{
    protected $articleRepo;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

    public function index($slug)
    {
        // TODO: implement
    }
}
