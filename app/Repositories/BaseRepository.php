<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements RepositoryInterface
{
    protected Model $model;
    protected array $with = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->applyRelations()->get($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->applyRelations()->paginate($perPage, $columns);
    }

    public function find(int $id): ?Model
    {
        return $this->applyRelations()->find($id);
    }

    public function findOrFail(int $id): Model
    {
        return $this->applyRelations()->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $model = $this->findOrFail($id);
        return $model->update($data);
    }

    public function delete(int $id): bool
    {
        $model = $this->findOrFail($id);
        return $model->delete();
    }

    public function where(string $column, $value): Collection
    {
        return $this->applyRelations()->where($column, $value)->get();
    }

    public function with(array $relations): self
    {
        $this->with = $relations;
        return $this;
    }

    protected function applyRelations()
    {
        $query = $this->model->newQuery();
        
        if (!empty($this->with)) {
            $query->with($this->with);
            $this->with = []; // Reset after applying
        }
        
        return $query;
    }
}
