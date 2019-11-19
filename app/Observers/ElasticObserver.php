<?php

namespace App\Observers;

use App\Search\Searchable;
use Elasticsearch\Client;

class ElasticObserver
{
    /**
     * Elastic client
     *
     * @var Client
     */
    private $elasticSearch;

    public function __construct(Client $elasticSearch)
    {
        $this->elasticSearch = $elasticSearch;
    }

    /**
     * Event when Model is saved when use Searchable trait is used
     *
     * @param Searchable $model
     * @return void
     */
    public function saved(Searchable $model)
    {
        $this->elasticSearch->index([
            'index' => $model->getSearchIndex(),
            'type'  => $model->getSearchType(),
            'id'    => $model->getKey(),
            'body'  => $model->toSearchArray()
        ]);
    }

    /**
     * Event when Model is deleted when use Searchable trait is used
     *
     * @param Searchable $model
     * @return void
     */
    public function deleted(Searchable $model)
    {
        $this->elasticSearch->delete([
            'index' => $model->getSearchIndex(),
            'type'  => $model->getSearchType(),
            'id'    => $model->getKey(),
        ]);
    }
}
