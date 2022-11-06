<?php

namespace App\Services;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

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
        $approveStatus = [ 'status' => '1' ];
        return $this->repo->searchBy($approveStatus, $search);
    }
    
    public function approvedPostsByUser(int $id, string $search): LengthAwarePaginator
    {
        $user = [ 'user_id' => $id, 'status' => '1'  ];
        return $this->repo->searchBy($user, $search);
    }

    public function getPost(int $id): Model
    {
        return $this->repo->getById($id);
    }
    public function deletePost(int $id): bool
    {
        return $this->repo->delete($id);
    }


}
