<?php

namespace App\Http\Controllers\Home\Blog;

use Covid\Blog\Blog\Tag as TagRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Covid\Blog\Models\Tag;

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
