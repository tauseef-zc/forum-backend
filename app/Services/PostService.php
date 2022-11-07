<?php

namespace App\Services;

use App\Models\User;
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
    
    /**
     * Crate Post Request
     *
     * @param  User $user
     * @param  array $data
     * @return Model
     */
    public function createPost(User $user, array $data): Model
    {
        if($user->type === '2'){
            $data['status'] = '1';
        }

        return $this->repo->store($data);
    }
        
    /**
     * Search Post
     *
     * @param  string $search
     * @return LengthAwarePaginator
     */
    public function searchPosts(string $search): LengthAwarePaginator
    {
        return $this->repo->searchData($search);
    }
        
    /**
     * Get Approved Posts
     *
     * @param  string $search
     * @return LengthAwarePaginator
     */
    public function approvedPosts(string $search): LengthAwarePaginator
    {
        $approveStatus = [ 'status' => '1' ];
        return $this->repo->searchBy($approveStatus, $search);
    }
        
    /**
     * Get Approved Post by User
     *
     * @param  int $id
     * @param  string $search
     * @return LengthAwarePaginator
     */
    public function approvedPostsByUser(int $id, string $search): LengthAwarePaginator
    {
        $user = [ 'user_id' => $id, 'status' => '1'  ];
        return $this->repo->searchBy($user, $search);
    }
    
    /**
     * Get a Single Post
     *
     * @param  int $id
     * @return Model
     */
    public function getPost(int $id): Model
    {
        return $this->repo->getById($id);
    }
    
    /**
     * Delete a Post
     *
     * @param  int $id
     * @return bool
     */
    public function deletePost(int $id): bool
    {
        return $this->repo->delete($id);
    }    
    /**
     * Updating a status
     *
     * @param  int $id
     * @param  mixed $status
     * @return Model
     */
    public function updateStatus(int $id, mixed $status): Model
    {
        $data = ['status' => "$status" ];
        return $this->repo->update($id, $data);
        
    }


}
