<?php

namespace App\Http\Controllers\Home\Blog;

use App\Repositories\Blog\TagRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog\Tag;

class TagController extends Controller
{
    protected $tagRepo;

    public function __construct(TagRepository $tagRepo)
    {
        $this->tagRepo = $tagRepo;
    }

    public function index($slug)
    {
        // TODO: implement
    }
}
