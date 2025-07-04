<?php

declare(strict_types=1);

namespace App\Models\Tags;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\Tag as SpatieTag;

final class Tag extends SpatieTag
{
    use SoftDeletes;
}
