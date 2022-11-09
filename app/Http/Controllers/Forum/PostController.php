<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
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

            $search = $request->has('search') && !empty($request->search) ? $request->search : '';
            $posts = $this->service->approvedPosts($search);
            
            throw_unless($posts, new Exception('Forums not found! Please tray again a while.', 404));
            
            return response()->ok('FETCHED', 'Forums successfully fetched!', [
                'forums' => $posts 
            ]);

       }catch(Exception | Throwable $exception){
            return response()->error('FAILED', $exception->getMessage());
       } 
    }
    
    /**
     * Retrieve post for single user
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function posts(Request $request): JsonResponse
    {
       try{

            $search = $request->has('search')  && !empty($request->search) ? $request->search : '';
            $posts = $this->service->getPostsByUser($request->user()->id, $search);
            
            throw_unless($posts, new Exception('Forums not found! Please tray again a while.', 404));
            
            return response()->ok('FETCHED', 'Forums successfully fetched!', [
                'forums' => $posts 
            ]);

       }catch(Exception | Throwable $exception){
            return response()->error('FAILED', $exception->getMessage());
       } 
    }
        
    /**
     * Submitting a new forum
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function submit(PostCreateRequest $request): JsonResponse
    {
       try{

            $inputs = $request->only('question', 'user_id');
            $post = $this->service->createPost($request->user(), $inputs);
            
            throw_unless($post, new Exception('Forums cannot be created.', 404));

            $message = 'Forum sumitted to admin successfully! It will be published once reviewed by the admin.';

            return response()->ok('SUBMITTED', $message, ['forum' => $post ]);

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

            if(request()->user()->type !== '2'){
               // Check user has permission to delete 
               throw_if(request()->user()->id !== $post->user_id, 
               new AuthenticationException("You don't have permission for this operation."));
            }
            
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
    
    /**
     * Get a single post
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function getPost(int $id): JsonResponse
    {
          try {

               $post = $this->service->getPost($id);
               throw_unless($post, new Exception('Forums not found! Please tray again a while.', 404));

               return response()->ok('FETCHED', 'Forums successfully fetched!', [
                    'forum' => $post,
                    'comments' => $post->comments,
                    'user' => $post->user 
               ]);

          } catch (Exception | Throwable $exception) {
               return response()->error('FAILED', $exception->getMessage());
          } 
    }

}
