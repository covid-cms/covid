<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Blog\CategoryRepository;
use App\Http\Controllers\Controller;
use App\Format\Blog\CategoryFormat;
use App\Http\Requests\Api\Blog\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function index(Request $request)
    {
        $results = $this->categoryRepo->query($request->all())->paginate();

        return response()->json($results);
    }

    public function store(Category\CreateRequest $request)
    {
        $standardizedData = $request->standardize()->all();
        $category = $this->categoryRepo->create($standardizedData);

        return response()->json([
            'error' => false,
            'data' => [
                'category' => $category->format(CategoryFormat::STANDARD)
            ]
        ]);
    }
}
