<?php

namespace App\Models\Tags;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\Tag as SpatieTag;

class Tag extends SpatieTag
{
    use SoftDeletes;
}
