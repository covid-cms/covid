<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use Covid\Blog\ArticleRepository;
use Illuminate\Http\Request;
use Covid\Blog\Models\Article;

class StatisticController extends Controller
{
    protected $articleRepo;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

    public function article()
    {
        return response()->json([
            'error' => false,
            'data' => [
                'total_count' => $this->articleRepo->query()->count(),
                'publish_count' => $this->articleRepo->query(['status' => Article::STATUS_PUBLISHED])->count(),
                'draft_count' => $this->articleRepo->query(['status' => Article::STATUS_DRAFT])->count(),
            ]
        ]);
    }
}
