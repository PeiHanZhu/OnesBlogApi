<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CommentController.
 */
class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     *
     * @group 04. Comments
     * @urlParam post integer required The id of the post. Example: 109
     * @queryParam limit integer The amount of results per page. Example: 10
     * @queryParam page integer The page of the results. Example: 1
     * @responseFile 200 scenario="when comments displayed." responses/comments.index/200.json
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Post $post)
    {
        return (new CommentCollection(
            $post->comments()->paginate($request->query('limit') ?? 10)
        ))->preserveQuery();
    }

    /**
     * Store a newly created comment in storage.
     *
     * @group 04. Comments
     * @authenticated
     * @header token Bearer {personal-access-token}
     * @urlParam post integer required The id of the post. Example: 109
     * @bodyParam content string The content of the comment. Example: commentTest
     * @responseFile 201 scenario="when comment created." responses/comments.store/201.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 404 scenario="when post not found." responses/comments.store/404.json
     * @responseFile 422 scenario="when any validation failed." responses/comments.store/422.json
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } elseif (!$post->active or $post->published_at > now()) {
            throw (new ModelNotFoundException)->setModel($post, $post->id);
        }

        return new CommentResource(
            $post->comments()->create(array_merge(['user_id' => $request->user()->id], $request->only([
                'content',
            ])))->refresh(),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified comment.
     *
     * @group 04. Comments
     * @urlParam post integer required The id of the post. Example: 109
     * @urlParam comment integer required The id of the comment. Example: 33
     * @responseFile 200 scenario="when comment displayed." responses/comments.show/200.json
     * @responseFile 404 scenario="when post not found." responses/comments.show/404_post.json
     * @responseFile 404 scenario="when comment not found." responses/comments.show/404_comment.json
     *
     * @param Post $post
     * @param Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified comment in storage.
     *
     * @group 04. Comments
     * @authenticated
     * @header token Bearer {personal-access-token}
     * @urlParam post integer required The id of the post. Example: 109
     * @urlParam comment integer required The id of the comment. Example: 32
     * @bodyParam content string required The content of the comment. Example: 0724Comment
     * @responseFile 200 scenario="when comment updated." responses/comments.update/200.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 404 scenario="when post not found." responses/comments.update/404_post.json
     * @responseFile 404 scenario="when comment not found." responses/comments.update/404_comment.json
     * @responseFile 422 scenario="when any validation failed." responses/comments.update/422.json
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     * @param Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } elseif ($request->user()->cant('update', $comment)) {
            throw new AuthorizationException;
        }

        $comment->update($request->only([
            'content',
        ]));

        return new CommentResource($comment->refresh());
    }

    /**
     * Remove the specified comment from storage.
     *
     * @group 04. Comments
     * @authenticated
     * @header token Bearer {personal-access-token}
     * @urlParam post integer required The id of the post. Example: 109
     * @urlParam comment integer required The id of the comment. Exmaple: 32
     * @responseFile 200 scenario="when comment deleted." responses/comments.destroy/200.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 404 scenario="when post not found." responses/comments.destroy/404_post.json
     * @responseFile 404 scenario="when comment not found." responses/comments.destroy/404_comment.json
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     * @param Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post, Comment $comment)
    {
        if ($request->user()->cant('delete', $comment)) {
            throw new AuthorizationException;
        } else {
            $comment->delete();
        }
        return response()->json([
            'data' => 'Success',
        ]);
    }
}
