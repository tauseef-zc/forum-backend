<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentSubmitRequest;
use App\Services\Interfaces\CommentServiceInterface as CommentService;
use App\Services\Interfaces\PostServiceInterface as PostService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class CommentController extends Controller
{
    protected CommentService $service;
    protected PostService $forum;
     
    function __construct(PostService $forum, CommentService $service)
    {
        $this->service = $service;
        $this->forum   = $forum;
    }
    
    /**
     * Submit comment for forum
     *
     * @param  CommentSubmitRequest $request
     * @param  int $forumId
     * @return JsonResponse
     */
    public function submit(CommentSubmitRequest $request, int $forumId): JsonResponse
    {
        try{
            $inputs = $request->only('comment', 'user_id');

            $post = $this->forum->getPost($forumId);
            throw_unless($post, new Exception('Forum not found for the given query.', 404));

            $inputs['question_id'] = $post->id;

            $comment = $this->service->addComment($request->user(), $inputs);
            throw_unless($comment, new Exception('Comment cannot be added to the forum.', 500));

            return response()->ok('SUBMITTED', 'Comment added to the forum successfully!');

       }catch(Exception | Throwable $exception){
            return response()->error('FAILED', $exception->getMessage());
       } 
    }
}
