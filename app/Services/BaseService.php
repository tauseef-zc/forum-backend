<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use App\Services\Interfaces\ServiceInterface;

abstract class BaseService implements ServiceInterface
{
    protected BaseRepository $repository;

    public function __construct(BaseRepository $reportRepository)
    {
        $this->repository = $reportRepository;
    }
}
