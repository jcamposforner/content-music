<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['deleted_at', 'updated_at'];

    public function imageable()
    {
        return $this->morphTo();
    }
}
