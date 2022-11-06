<?php

namespace App\Services\Interfaces;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostServiceInterface extends ServiceInterface
{

    public function searchPosts(string $search): LengthAwarePaginator;

    public function approvedPosts(string $search): LengthAwarePaginator;

}
