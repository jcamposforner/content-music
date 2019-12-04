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
}
