<?php

namespace App\Search;

interface SearchableInterface
{
    public function getSearchIndex(): string;
    public function getSearchType(): string;
    public function toSearchArray(): array;
    public function getKey();
}
