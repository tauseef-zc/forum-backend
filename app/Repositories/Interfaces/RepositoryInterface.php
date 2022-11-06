<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{

    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model;

    /**
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * @param int $id
     * @return Model
     */
    public function getById(int $id): Model;

    /**
     * @param array $has
     * @param array $data
     * @return Model
     */
    public function updateOrStore(array $has, array $data): Model;

    /**
     * @return Collection
     */
    public function getAllData(): Collection;

}
