<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostKeepCollection;
use App\Http\Resources\PostKeepResource;
use App\Models\Post;
use App\Models\PostKeep;
use Illuminate\Http\Request;

/**
 * Class PostKeepController.
 *
 * @group 07. PostKeeps
 */
class PostKeepController extends Controller
{
    /**
     * Display a listing of the post.
     *
     * @queryParam user_id integer The id of the user. Example: 2
     * @queryParam limit integer The amount of results per page. Defaults to '10'. Example: 10
     * @queryParam page integer The page of the results. Defaults to '1'. Example: 1
     * @responseFile 200 scenario="when post keeps displayed." responses/post_keeps.index/200.json
     * @responseFile 200 scenario="when post keeps displayed queried by user's id." responses/post_keeps.index/200_queried_by_user_id.json
     *
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        if (!is_null($userId = $request->query('user_id'))) {
            return (new PostCollection(
                Post::whereHas('postkeeps', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->where('active', true)->paginate($request->query('limit') ?? 10)
            ))->preserveQuery();
        } else {
            return (new PostKeepCollection(
                PostKeep::when($request->query('user_id'), function ($query, $userId) {
                    $query->where('user_id', $userId);
                })->paginate($request->query('limit') ?? 10)
            ))->preserveQuery();
        }
    }

    /**
     * Store a newly created or remove the specified post keep in storage.
     *
     * @authenticated
     * @header Authorization Bearer {personal-access-token}
     * @urlParam post integer required The id of the post. Example: 5
     * @responseFile 200 scenario="when post keep deleted." responses/post_keeps.store/200.json
     * @responseFile 201 scenario="when post keep created." responses/post_keeps.store/201.json
     * @responseFile 404 scenario="when post not found." responses/post_keeps.store/404.json
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     */
    public function store(Request $request, Post $post)
    {
        if (is_null($postKeep = PostKeep::where([
            ['user_id', $request->user()->id],
            ['post_id', $post->id],
        ])->first())) {
            return new PostKeepResource(PostKeep::create([
                'user_id' => $request->user()->id,
                'post_id' => $post->id,
            ]));
        } else {
            $postKeep->delete();
            return response()->json([
                'data' => 'Success',
            ]);
        }
    }
}
