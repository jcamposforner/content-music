<?php


namespace App\Repositories;

use App\Content;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContentRepository implements ContentRepositoryInterface
{
    protected $model;

    public function __construct(Content $content)
    {
        $this->model = $content;
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): Model
    {
        $content = $this->model->find($id);

        if (!$content) {
            throw new ModelNotFoundException();
        }

        return $content;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): int
    {
        return $this->model->destroy($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }
}
