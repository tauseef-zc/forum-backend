<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\CommentServiceInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CommentService extends BaseService implements CommentServiceInterface
{
    protected CommentRepositoryInterface $repo;

    function __construct(CommentRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function addComment(User $user, array $data): Model
    {
        $data['status'] = '1';
        return $this->repo->store($data);
    }
    
}
