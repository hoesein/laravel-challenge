<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Requests\ToggleReactionRequest;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function list()
    {
        $data = PostResource::collection(Post::with('author', 'tags')->get());

        return response()->json([
            'status' => 200,
            'data' => $data,
        ])
        ->setStatusCode(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK]);
    }
    
    public function toggleReaction(ToggleReactionRequest $request)
    {
        $post = Post::find($request->post_id);
        if(!$post) {
            return response()->json([
                'status' => 400,
                'message' => 'model not found'
            ])
            ->setStatusCode(Response::HTTP_NOT_FOUND, Response::$statusTexts[Response::HTTP_NOT_FOUND]);
        }

        if($post->user_id == auth()->id()) {
            return response()->json([
                'status' => 500,
                'message' => 'You cannot like your post'
            ])
            ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR, Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

        $like = Like::with('likedUser')->where([
            ['post_id', $request->post_id],
            ['user_id', auth()->id()]
        ])->first();

        if($like && $like->post_id == $request->post_id && $request->like) {
            
            return response()->json([
                'status' => 500,
                'message' => 'You already liked this post'
            ])
            ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR, Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]);

        }elseif($like && $like->post_id == $request->post_id && !$request->like) {
            
            $like->delete();
            
            return response()->json([
                'status' => 200,
                'message' => 'You unlike this post successfully'
            ])
            ->setStatusCode(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK]);

        }
        
        Like::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id()
        ]);
        
        return response()->json([
            'status' => 200,
            'message' => 'You like this post successfully'
        ])
        ->setStatusCode(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK]);
    }
}
