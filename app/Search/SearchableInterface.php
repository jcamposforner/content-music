<?php

namespace App\Search;

interface SearchableInterface
{
    /**
     * Get table name to create or search on index
     *
     * @return string
     */
    public function getSearchIndex(): string;

    /**
     * If property useSearchType exists in model use his value, if not return table name
     *
     * @return string
     */
    public function getSearchType(): string;

    /**
     * Convert model to an array
     *
     * @return array
     */
    public function toSearchArray(): array;

    /**
     * Get Primary Key
     *
     * @return integer|string
     */
    public function getKey();
}
