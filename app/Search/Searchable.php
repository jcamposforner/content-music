<?php

namespace App\Search;

use App\Observers\ElasticObserver;

trait Searchable
{
    public static function bootSearchable()
    {
        static::observe(ElasticObserver::class);
    }

    /**
     * Get table name to create or search on index
     *
     * @return string
     */
    public function getSearchIndex(): string
    {
        return $this->getTable();
    }

    /**
     * If property useSearchType exists in model use his value, if not return table name
     *
     * @return string
     */
    public function getSearchType(): string
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }

        return $this->getTable();
    }

    /**
     * Convert model to an array
     *
     * @return array
     */
    public function toSearchArray(): array
    {
        return $this->toArray();
    }
}
