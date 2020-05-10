<?php

namespace App\Http\Controllers\Api\Blog;

use App\Repositories\Blog\CategoryRepository;
use App\Http\Controllers\Controller;
use App\Format\Blog\CategoryFormat;
use App\Http\Requests\Api\Blog\Category as CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Blog\Category;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryRepo->query($request->all())->get();

        $formatedCategories = CategoryFormat::formatList($categories, CategoryFormat::STANDARD);

        return response()->json([
            'error' => false,
            'data' => [
                'categories' => $formatedCategories
            ]
        ]);
    }

    public function show(Category $category)
    {
        return response()->json([
            'error' => false,
            'data' => [
                'category' => $category->format(CategoryFormat::DETAIL)
            ]
        ]);
    }

    public function store(CategoryRequest\CreateRequest $request)
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

    public function update(CategoryRequest\UpdateRequest $request, Category $category)
    {
        $standardizedData = $request->standardize()->all();

        $this->categoryRepo->update($category, $standardizedData);

        return response()->json([
            'error' => false,
            'data' => [
                'category' => $category->format(CategoryFormat::STANDARD)
            ]
        ]);
    }

    public function destroy(Category $category)
    {
        $this->categoryRepo->delete($category);

        return response()->json([
            'error' => false,
        ]);
    }
}
