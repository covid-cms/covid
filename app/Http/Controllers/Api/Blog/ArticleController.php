<?php

namespace App\Http\Controllers\Api\Blog;

use App\Repositories\Blog\ArticleRepository;
use App\Http\Controllers\Controller;
use App\Format\Blog\ArticleFormat;
use App\Http\Requests\Api\Blog\Article as ArticleRequest;
use Illuminate\Http\Request;
use App\Models\Blog\Article;
use Illuminate\Validation\ValidationException;

class ArticleController extends Controller
{
    protected $articleRepo;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

    public function index(Request $request)
    {
        $paginatedArticles = $this->articleRepo
            ->query($request->all())
            ->with(['categories'])
            ->latest('id')
            ->paginate();

        $paginatedArticles = ArticleFormat::formatPaginate($paginatedArticles, ArticleFormat::STANDARD);

        return response()->json($paginatedArticles);
    }

    public function show(Article $article)
    {
        return response()->json([
            'error' => false,
            'data' => [
                'article' => $article->format(ArticleFormat::DETAIL)
            ]
        ]);
    }

    public function store(ArticleRequest\CreateRequest $request)
    {
        $standardizedData = $request->standardize()->all();
        $standardizedData['author_id'] = $request->user()->id;

        try {
            $article = $this->articleRepo->create($standardizedData);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => true,
                'errors' => $exception->errors(),
            ]);
        }

        return response()->json([
            'error' => false,
            'data' => [
                'article' => $article->format(ArticleFormat::STANDARD)
            ]
        ]);
    }

    public function update(ArticleRequest\UpdateRequest $request, Article $article)
    {
        $standardizedData = $request->standardize()->all();

        try {
            $this->articleRepo->update($article, $standardizedData);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => true,
                'errors' => $exception->errors(),
            ]);
        }

        return response()->json([
            'error' => false,
            'data' => [
                'article' => $article->format(ArticleFormat::STANDARD)
            ]
        ]);
    }

    public function destroy(Article $article)
    {
        $this->articleRepo->delete($article);

        return response()->json([
            'error' => false,
        ]);
    }
}
