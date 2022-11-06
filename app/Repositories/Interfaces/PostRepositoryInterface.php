<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function searchData(string $search): LengthAwarePaginator;

    public function searchByStatus(int $status, string $search): LengthAwarePaginator;
    
}