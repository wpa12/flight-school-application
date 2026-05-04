<?php

declare(strict_types=1);

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

// Base repository class for all repositories to extend from
abstract class BaseRepository
{
    public function __construct(protected Model $model) {}

    /**
     * Get all models
     *
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    /**
     * Find a model by id
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): Model|null
    {
        return $this->model->find($id);
    }

    /**
     * Create a new model
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update a model
     *
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }
    
    /**
     * Delete a model
     *
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        return $model->delete();
    }
}