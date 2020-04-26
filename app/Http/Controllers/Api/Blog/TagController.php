<?php

namespace App\Http\Controllers\Api\Blog;

use App\Repositories\Blog\TagRepository;
use App\Http\Controllers\Controller;
use App\Format\Blog\TagFormat;
use App\Http\Requests\Api\Blog\Tag as TagRequest;
use Illuminate\Http\Request;
use App\Models\Blog\Tag;

class TagController extends Controller
{
    protected $tagRepo;

    public function __construct(TagRepository $tagRepo)
    {
        $this->tagRepo = $tagRepo;
    }

    public function index(Request $request)
    {
        $paginatedTags = $this->tagRepo->query($request->all())->paginate();

        return response()->json($paginatedTags);
    }

    public function store(TagRequest\CreateRequest $request)
    {
        $standardizedData = $request->standardize()->all();
        $tag = $this->tagRepo->create($standardizedData);

        return response()->json([
            'error' => false,
            'data' => [
                'tag' => $tag->format(TagFormat::STANDARD)
            ]
        ]);
    }

    public function update(TagRequest\UpdateRequest $request, Tag $tag)
    {
        $standardizedData = $request->standardize()->all();

        $this->tagRepo->update($tag, $standardizedData);

        return response()->json([
            'error' => false,
            'data' => [
                'tag' => $tag->format(TagFormat::STANDARD)
            ]
        ]);
    }

    public function destroy(Tag $tag)
    {
        $this->tagRepo->delete($tag);

        return response()->json([
            'error' => false,
        ]);
    }
}
