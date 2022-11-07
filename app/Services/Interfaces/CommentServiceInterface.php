<?php

namespace App\Services\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface CommentServiceInterface extends ServiceInterface
{

     public function addComment(User $user, array $data): Model;
     
}