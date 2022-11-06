<?php

namespace App\Services\Interfaces;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface PostServiceInterface extends ServiceInterface
{

    public function searchPosts(string $search): LengthAwarePaginator;

    public function approvedPosts(string $search): LengthAwarePaginator;

    public function approvedPostsByUser(int $id, string $search): LengthAwarePaginator;

    public function getPost(int $id): Model;

    public function deletePost(int $id): bool;

}
