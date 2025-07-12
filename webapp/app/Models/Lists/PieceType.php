<?php

declare(strict_types=1);

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
final class PieceType extends Model
{
    use HasFactory;
    use HasSlug;

    public $timestamps = false;

    /** @noinspection PackedHashtableOptimizationInspection */
    private const array THRESHOLDS = [
        1000 => 1000,
        100 => 100,
        10 => 10,
    ];

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
            $count = random_int($type->min_count, $type->max_count);
        } catch (Exception) {
            return $type->min_count;
        }

        return self::roundToNearestThreshold($count);
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

    private static function roundToNearestThreshold(int $count): int
    {
        foreach (self::THRESHOLDS as $threshold => $base) {
            if ($count < $threshold) {
                continue;
            }

            return (int) round($count / $base) * $base;
        }

        return (int) round($count / 10) * 10;
    }
}
