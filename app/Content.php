<?php

namespace App;

use App\Search\Searchable;
use App\Search\SearchableInterface;
use Illuminate\Database\Eloquent\Model;

class Content extends Model implements SearchableInterface
{
    use Searchable;

    protected $guarded = [];

    /**
     * Eager loading for saving on ElasticSearch
     *
     * @var array
     */
    protected $with = ['Image', 'Tags'];

    public function image()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
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
