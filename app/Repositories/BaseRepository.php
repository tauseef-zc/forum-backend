<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements RepositoryInterface
{
    protected Model $model;

    public function store(array $data): Model
    {
        try {

            DB::beginTransaction();
            $model = $this->model->create($data);
            DB::commit();

            return $model;

        } catch (\mysqli_sql_exception $exception) {
            DB::rollBack();
            throw new ModelNotFoundException($exception->getMessage(), $exception->getCode());
        }
    }

    public function updateOrStore(array $has, array $data): Model
    {
        try {

            DB::beginTransaction();
            $model = $this->model->updateOrCreate($has, $data);
            DB::commit();

            return $model;

        } catch (\mysqli_sql_exception $exception) {
            DB::rollBack();
            throw new ModelNotFoundException($exception->getMessage(), $exception->getCode());
        }
    }

    public function update(int $id, array $data): Model
    {
        try {

            DB::beginTransaction();
            $item = $this->getById($id);
            $this->model->find($item->id)->update($data);
            DB::commit();

            return $this->getById($id);

        } catch (\mysqli_sql_exception $exception) {
            DB::rollBack();
            throw new ModelNotFoundException($exception->getMessage(), $exception->getCode());
        }
    }

    public function delete(int $id): bool
    {
        $result = $this->model->findOrFail($id);
        if (!$result)
            return false;

        return $result->delete();
    }

    public function getById(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function getAllData(): Collection
    {
        return $this->model->orderBy('id', 'asc')->get();
    }
}