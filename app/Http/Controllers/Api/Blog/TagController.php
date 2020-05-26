<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Requests\Api\Blog\Tag as TagRequest;
use App\Http\Controllers\Controller;
use Covid\Blog\TagRepository;
use Covid\Blog\Format\TagFormat;
use Covid\Blog\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Str;

class TagController extends Controller
{
    protected $tagRepo;

    public function __construct(TagRepository $tagRepo)
    {
        $this->tagRepo = $tagRepo;
    }

    public function index(Request $request)
    {
        $tags = $this->tagRepo->query($request->all())->withCount('articles')->latest('id')->get();

        $formatedTags = TagFormat::formatList($tags, TagFormat::STANDARD);

        return response()->json([
            'error' => false,
            'data' => [
                'tags' => $formatedTags
            ]
        ]);
    }

    public function show(Tag $tag)
    {
        return response()->json([
            'error' => false,
            'data' => [
                'tag' => $tag->format(TagFormat::DETAIL)
            ]
        ]);
    }

    public function store(TagRequest\CreateRequest $request)
    {
        $standardizedData = $request->standardize()->all();

        try {
            $tag = $this->tagRepo->create($standardizedData);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => true,
                'errors' => $exception->errors(),
            ]);
        }

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


        try {
            $this->tagRepo->update($tag, $standardizedData);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => true,
                'errors' => $exception->errors(),
            ]);
        }

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
