<?php

namespace App\Models\Lists;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasSlug;

/**
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $weight
 * @property bool $active
 */
class Timeline extends Model
{
    use HasFactory;
    use HasSlug;

    public $timestamps = false;

    protected $fillable = [
        'slug',
        'name',
        'weight',
        'active',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function scopeWeightedRandom(Builder $query): Builder
    {
        return $query->orderByRaw('RAND() * weight DESC');
    }

    protected function casts(): array
    {
        return [
            'weight' => 'integer',
            'active' => 'boolean',
        ];
    }
}
