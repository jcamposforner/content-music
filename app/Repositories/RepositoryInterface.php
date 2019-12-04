<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface RepositoryInterface
{
    /**
     * @param int $id
     *
     * @throws ModelNotFoundException
     *
     * @return Model
     */
    public function find(int $id): Model;

    /**
     * @param int $id
     *
     * @return int
     */
    public function delete(int $id): int;

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;
}
