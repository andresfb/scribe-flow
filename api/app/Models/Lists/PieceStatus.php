<?php

namespace App\Models\Lists;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property bool $active
 * @property bool $default
 * @property int $order
 */
class PieceStatus extends Model
{
    use HasFactory;
    use HasSlug;

    public $timestamps = false;

    protected $fillable = [
        'slug',
        'name',
        'active',
        'default',
        'order',
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
            'default' => 'boolean',
            'order' => 'integer',
        ];
    }

    public static function getDefault(): int
    {
        return self::query()
            ->where('active', true)
            ->where('default', true)
            ->firstOrFail()
            ->id;
    }
}
