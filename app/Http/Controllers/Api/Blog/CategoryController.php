<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Blog\Category as CategoryRequest;
use Covid\Blog\CategoryRepository;
use Covid\Blog\Format\CategoryFormat;
use Covid\Blog\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryRepo->query($request->all())->withCount('articles')->latest('id')->get();

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

        try {
            $category = $this->categoryRepo->create($standardizedData);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => true,
                'errors' => $exception->errors(),
            ]);
        }

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

        try {
            $this->categoryRepo->update($category, $standardizedData);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => true,
                'errors' => $exception->errors(),
            ]);
        }

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
