<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\PostServiceInterface;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class PostController extends Controller
{
    protected PostServiceInterface $service;

    function __construct(PostServiceInterface $service)
    {
        $this->service = $service;    
    }
    
    /**
     * Fetching Approved post for the user
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
       try{

            $search = $request->has('search') ? $request->search : '';
            $posts = $this->service->approvedPosts($search);
            
            throw_unless($posts, new Exception('Forums not found! Please tray again a while.', 404));
            
            return response()->ok('FETCHED', 'Forums successfully fetched!', [
                'forums' => $posts 
            ]);

       }catch(Exception | Throwable $exception){
            return response()->error('FAILED', $exception->getMessage());
       } 
    }

    public function posts(Request $request): JsonResponse
    {
       try{

            $search = $request->has('search') ? $request->search : '';
            $posts = $this->service->approvedPostsByUser($request->user()->id, $search);
            
            throw_unless($posts, new Exception('Forums not found! Please tray again a while.', 404));
            
            return response()->ok('FETCHED', 'Forums successfully fetched!', [
                'forums' => $posts 
            ]);

       }catch(Exception | Throwable $exception){
            return response()->error('FAILED', $exception->getMessage());
       } 
    }
    
    /**
     * Delete the post for the user
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try{

            // Getting the post
            $post = $this->service->getPost($id);
            throw_unless($post, new Exception('Forum not found for the given query.', 404));

            // Check user has permission to delete 
            throw_if(request()->user()->id !== $post->user_id, 
            new AuthenticationException("You don't have permission for this operation."));

            // Delete post action
            $delete = $this->service->deletePost($post->id);
            throw_if(!$delete, new Exception('Cannot delete Forum!'));
            
            return response()->ok('REMOVED', 'Forum deleted successfully!');

       }catch(AuthenticationException $exception){
            return response()->unauthorized('UNAUTHENTICATED', $exception->getMessage());
       }catch(Exception | Throwable $exception){
            return response()->error('FAILED', $exception->getMessage());
       } 
    }

}
