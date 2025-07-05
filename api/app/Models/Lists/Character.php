<?php

namespace App\Models\Lists;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasSlug;

/**
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property bool $active
 */
class Character extends Model
{
    use HasSlug;

    public $timestamps = false;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'active',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }
}
