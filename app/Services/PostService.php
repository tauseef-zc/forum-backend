<?php

namespace App\Services;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostService extends BaseService implements PostServiceInterface
{
    protected PostRepositoryInterface $repo;

    function __construct(PostRepositoryInterface $postRepository)
    {
        $this->repo = $postRepository;
    }

    public function searchPosts(string $search): LengthAwarePaginator
    {
        return $this->repo->searchData($search);
    }
    
    public function approvedPosts(string $search): LengthAwarePaginator
    {
        $approveStatus = 1;
        return $this->repo->searchByStatus($approveStatus, $search);
    }
}
