<?php

namespace App\Repositories;

use App\Models\Question;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    protected Model $model;

    function __construct(Question $model)
    {
        $this->model = $model;
    }

    public function searchData(string $search): LengthAwarePaginator
    {
        return $this->model->where('question', 'LIKE', "%$search%")
            ->orderBy('created_at', 'DESC')
            ->paginate(12);
    }
    
    public function searchByStatus(int $status, string $search): LengthAwarePaginator
    {
        return $this->model->where('question', 'LIKE', "%$search%")
            ->where('status', "$status")
            ->orderBy('created_at', 'DESC')
            ->paginate(12);
    }
}
