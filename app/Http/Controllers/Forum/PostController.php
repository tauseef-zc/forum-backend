<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\PostServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class PostController extends Controller
{
    protected PostServiceInterface $service;

    function __construct(PostServiceInterface $service)
    {
        $this->service = $service;    
    }

    public function index(Request $request)
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

}
