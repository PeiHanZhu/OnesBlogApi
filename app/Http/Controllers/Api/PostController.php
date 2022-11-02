<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\FileHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


/**
 * Class PostController.
 *
 * @group 06. Posts
 */
class PostController extends Controller
{
    use FileHandler;

    /**
     * Display a listing of the posts.
     *
     * @queryParam category_id integer The id of the category. Example: 2
     * @queryParam location_id integer The id of the location. Example: 2
     * @queryParam limit integer The amount of results per page. Defaults to '10'. Example: 10
     * @queryParam page integer The page of the results. Defaults to '1'. Example: 1
     * @responseFile 200 scenario="when posts displayed." responses/posts.index/200.json
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return (new PostCollection(
            Post::when($request->query('category_id'), function ($query, $categoryId) {
                $query->whereHas('location', function ($query) use ($categoryId) {
                    $query->where([
                        ['category_id', $categoryId],
                    ]);
                });
            })->when($request->query('location_id'), function ($query, $locationId) {
                $query->where('location_id', $locationId);
            })->when($request->query('user_id'), function ($query, $userId) {
                $query->where('user_id', $userId);
            })->where([
                ['active', true],
                ['published_at', '<=', now()],
            ])->paginate($request->query('limit') ?? 10)
        ))->preserveQuery();
    }

    /**
     * Store a newly created post in storage.
     *
     * @authenticated
     * @header Authorization Bearer {personal-access-token}
     * @bodyParam location_id integer required The location of the post. Example: 6
     * @bodyParam title string required The title of the post. Example: Post
     * @bodyParam content string The content of the post. Example: Test
     * @bodyParam published_at string The published time of the post. Example: 2022-07-23T08:31:45.000000Z
     * @bodyParam active boolean The state of the post. Example: 1
     * @bodyParam images file[] The images of the post. Example: .jpg, .jpeg, .png
     * @responseFile 201 scenario="when post created." responses/posts.store/201.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 422 scenario="when any validation failed." responses/posts.store/422.json
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'content' => 'nullable',
            'published_at' => 'nullable|date',
            'active' => 'boolean',
            'images.*' => ['nullable', 'mimes:jpg,jpeg,png', 'max:10240'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $post = Post::create(array_merge([
            'user_id' => $request->user()->id
        ], $request->only([
            'location_id',
            'title',
            'content',
            'published_at',
            'active',
        ])));

        $filePaths = [];
        foreach ($request->file('images', []) as $file) {
            (($path = $file->store("/posts/{$post->id}", 'public')) === false) ?:
                $filePaths[] = $path;
        }
        $post->images = $filePaths;
        $post->save();

        return new PostResource($post);
    }

    /**
     * Display the specified post.
     *
     * @urlParam post integer required The id of the post. Example: 108
     * @responseFile 200 scenario="when post displayed." responses/posts.show/200.json
     * @responseFile 404 scenario="when post not found, inactive or unpublished." responses/posts.show/404.json
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     * @throws ModelNotFoundException
     */
    public function show(Post $post)
    {
        if (!$post->active or $post->published_at > now()) {
            throw (new ModelNotFoundException)->setModel($post, $post->id);
        }
        return new PostResource($post);
    }

    /**
     * Update the specified post in storage.
     *
     * @authenticated
     * @header Authorization Bearer {personal-access-token}
     * @urlParam post integer required The id of the post. Example: 108
     * @bodyParam title string The title of the post. Example: 0724Post
     * @bodyParam content string The content of the post. Example: 0724Test
     * @bodyParam published_at string The published time of the post. Example: 20220724
     * @bodyParam active boolean The state of the post. Example: 1
     * @bodyParam images file[] The images of the post. Example: .jpg, .jpeg, .png
     * @bodyParam _method string Required if the <code><b>images</b></code> of the post are uploaded, must be <b>PUT</b> and request method must be <small class="badge badge-black">POST</small>. Example: PUT
     * @responseFile 200 scenario="when post updated." responses/posts.update/200.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 404 scenario="when post not found." responses/posts.update/404.json
     * @responseFile 422 scenario="when any validation failed." responses/posts.update/422.json
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if (str_contains(
            $request->header('content-type'),
            $contentType = 'multipart/form-data;'
        ) and $request->input('_method') !== Request::METHOD_PUT) {
            return response()->json([
                'data' => [
                    '_method' => [
                        sprintf(
                            'Content type %s must be method:%s, with input _method:%s',
                            $contentType,
                            Request::METHOD_POST,
                            Request::METHOD_PUT
                        ),
                    ],
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'content' => 'nullable',
            'published_at' => 'nullable|date',
            'active' => 'nullable|boolean',
            'images.*' => ['nullable', 'mimes:jpg,jpeg,png', 'max:10240'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($request->user()->cant('update', $post)) {
            throw new AuthorizationException();
        }

        $input = $request->only([
            'title',
            'content',
            'published_at',
            'active',
        ]);
        if ($request->hasFile('images')) {
            $filePaths = [];
            empty($post->images) ?: static::deleteDirectory($post);
            foreach ($request->file('images', []) as $file) {
                (($path = $file->store("/posts/{$post->id}", 'public')) === false) ?:
                    $filePaths[] = $path;
            }
            $input['images'] = $filePaths;
        }

        $post->update($input);

        return new PostResource($post->refresh());
    }

    /**
     * Remove the specified post from storage.
     *
     * @authenticated
     * @header Authorization Bearer {personal-access-token}
     * @urlParam post integer required The id of the post. Example: 108
     * @responseFile 200 scenario="when post deleted." responses/posts.destroy/200.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 404 scenario="when post not found." responses/posts.destroy/404.json
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post)
    {
        if ($request->user()->cant('delete', $post)) {
            throw new AuthorizationException();
        } else {
            $post->delete();
        }

        return response()->json([
            'data' => 'Success',
        ]);
    }
}
