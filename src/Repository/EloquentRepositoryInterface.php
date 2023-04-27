<?php

namespace TimWassenburg\RepositoryGenerator\Repository;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface EloquentRepositoryInterface
 */
interface EloquentRepositoryInterface
{
    public function create(array $attributes): Model;

    public function find(int $id, array $with = [], array $params = []): ?Model;

    public function findWithTrash(int $id): ?Model;

    public function delete(int $id);

    public function update(int $id, array $attributes): bool;
}
