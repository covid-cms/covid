<?php

namespace App\Http\Controllers\Home\Blog;

use Covid\Blog\Blog\CategoryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Covid\Blog\Models\Category;

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
