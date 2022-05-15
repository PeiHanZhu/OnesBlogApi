<?php

namespace App\Http\Controllers\Api;

use App\Enums\PostCategoryEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return (new PostCollection(
            Post::when($request->query('category_id'), function ($query, $categoryId) {
                $query->where([
                    ['category_id', $categoryId],
                    ['active', true],
                    ['published_at', '<=', now()],
                ]);
            })->paginate($request->query('limit') ?? 10)
        ))->preserveQuery();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'store_id' => 'required|integer',
            'category_id' => ['required', 'integer', Rule::in(PostCategoryEnum::getAllCategoryValues())],
            'title' => 'required|string|max:255',
            'content' => 'nullable',
            'published_at' => 'nullable|date',
            'active' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new PostResource(
            Post::create($request->only([
                'user_id',
                'store_id',
                'category_id',
                'title',
                'content',
                'published_at',
                'active',
            ]))->refresh(),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     * @throws ModelNotFoundException
     */
    public function show(Post $post)
    {
        if (!$post->active or $post->published_at > now()) {
            throw new ModelNotFoundException('Post not found');
        }
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => ['integer', Rule::in(PostCategoryEnum::getAllCategoryValues())],
            'title' => 'string|max:255',
            'content' => 'nullable',
            'published_at' => 'nullable|date',
            'active' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $post->update($request->only([
            'category_id',
            'title',
            'content',
            'published_at',
            'active',
        ]));

        return new PostResource($post->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'data' => 'Success',
        ]);
    }
}
