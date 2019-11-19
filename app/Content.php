<?php

namespace App;

use App\Search\Searchable;
use App\Search\SearchableInterface;
use Illuminate\Database\Eloquent\Model;

class Content extends Model implements SearchableInterface
{
    use Searchable;

    protected $guarded = [];

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
}
