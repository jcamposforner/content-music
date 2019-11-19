<?php

namespace App\Observers;

use App\Search\SearchableInterface;
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
     * Event when Model is saved when Searchable trait is used
     *
     * @param SearchableInterface $model
     * @return void
     */
    public function saved(SearchableInterface $model)
    {
        $this->elasticSearch->index([
            'index' => $model->getSearchIndex(),
            'type'  => $model->getSearchType(),
            'id'    => $model->getKey(),
            'body'  => $model->toSearchArray()
        ]);
    }

    /**
     * Event when Model is deleted when Searchable trait is used
     *
     * @param SearchableInterface $model
     * @return void
     */
    public function deleted(SearchableInterface $model)
    {
        $this->elasticSearch->delete([
            'index' => $model->getSearchIndex(),
            'type'  => $model->getSearchType(),
            'id'    => $model->getKey(),
        ]);
    }
}
