<?php

namespace App\Http\Controllers\Home\Blog;

use App\Repositories\Blog\CategoryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog\Category;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function index($slug)
    {
        // TODO: implement
    }
}
