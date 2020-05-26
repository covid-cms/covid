<?php

namespace App\Http\Controllers\Home\Blog;

use Covid\Blog\ArticleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Covid\Blog\Models\Article;

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
