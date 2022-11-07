<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostStatusRequest;
use App\Services\Interfaces\PostServiceInterface;
use Exception;
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
     * index
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
       try{

            $search = $request->has('search') ? $request->search : '';
            $posts = $this->service->searchPosts($search);
            
            throw_unless($posts, new Exception('Forums not found! Please tray again a while.', 404));
            
            return response()->ok('FETCHED', 'Forums successfully fetched!', [
                'forums' => $posts 
            ]);

       }catch(Exception | Throwable $exception){
            return response()->error('FAILED', $exception->getMessage());
       } 
    }
    
    /**
     * Admin submission forum
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function submit(PostCreateRequest $request): JsonResponse
    {
       try{

            $inputs = $request->only('question', 'user_id');
            $post = $this->service->createPost($request->user(), $inputs);
            
            throw_unless($post, new Exception('Forum cannot be created.', 404));

            return response()->ok('SUBMITTED', 'Forum published successfully!');

       }catch(Exception | Throwable $exception){
            return response()->error('FAILED', $exception->getMessage());
       } 
    }
        
    /**
     * Admin status update for Forum
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function updateStatus(PostStatusRequest $request, int $id): JsonResponse
    {
       try{

            $status = $request->status;
            $post = $this->service->updateStatus($id, $status);
            
            throw_unless($post, new Exception('Forum status cannot be updated!.', 404));

            return response()->ok('SUBMITTED', 'Forum updated successfully!');

       }catch(Exception | Throwable $exception){
            return response()->error('FAILED', $exception->getMessage());
       } 
    }

}
