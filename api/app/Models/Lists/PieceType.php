<?php

namespace App\Models\Lists;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property int $min_count
 * @property int $max_count
 * @property bool $randomizable
 * @property bool $active
 * @property int $order
 */
class PieceType extends Model
{
    use HasFactory;
    use HasSlug;

    public $timestamps = false;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'min_count',
        'max_count',
        'randomizable',
        'active',
    ];

    public static function getWordCount(int $pieceTypeId): int
    {
        $type = self::query()
            ->where('id', $pieceTypeId)
            ->first();

        if ($type === null) {
            return 1000;
        }

        try {
            $maxMultiple = (int) floor($type->max_count / $type->min_count);

            return random_int(1, $maxMultiple) * $type->max_count;
        } catch (Exception) {
            return $type->min_count;
        }
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected function casts(): array
    {
        return [
            'randomizable' => 'boolean',
            'active' => 'boolean',
            'min_count' => 'integer',
            'max_count' => 'integer',
            'order' => 'integer',
        ];
    }
}
