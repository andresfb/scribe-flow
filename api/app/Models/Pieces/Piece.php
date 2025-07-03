<?php

namespace App\Models\Pieces;

use App\Models\Lists\PieceGenre;
use App\Models\Lists\PiecePov;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\PieceTense;
use App\Models\Lists\PieceTheme;
use App\Models\Lists\PieceTone;
use App\Models\Lists\PieceType;
use App\Models\Pieces\Scopes\PieceWithScope;
use App\Models\User;
use App\Traits\DateAttributable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

/**
 * @property int $id
 * @property int $user_id
 * @property int $piece_type_id
 * @property int $piece_status_id
 * @property int $piece_pov_id
 * @property int $piece_tense_id
 * @property int $piece_genre_id
 * @property int $piece_sub_genre_id
 * @property int $piece_tone_id
 * @property int $piece_theme_id
 * @property string $slug
 * @property string $title
 * @property string $genre
 * @property string $sub_genre
 * @property string $setting_time_period
 * @property string $setting_location
 * @property string $synopsis
 * @property array $themes
 * @property int $target_word_count
 * @property int $current_word_count
 * @property Carbon $start_date
 * @property Carbon $target_completion_date
 * @property Carbon $completion_date
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Piece extends Model
{
    use DateAttributable;
    use HasFactory;
    use HasSlug;
    use HasTags;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'piece_type_id',
        'piece_status_id',
        'piece_pov_id',
        'piece_tense_id',
        'piece_genre_id',
        'piece_sub_genre_id',
        'piece_tone_id',
        'piece_theme_id',
        'title',
        'genre',
        'sub_genre',
        'setting_time_period',
        'setting_location',
        'synopsis',
        'target_word_count',
        'current_word_count',
        'start_date',
        'target_completion_date',
        'completion_date',
        'themes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(PieceType::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PieceStatus::class);
    }

    public function pov(): BelongsTo
    {
        return $this->belongsTo(PiecePov::class);
    }

    public function tense(): BelongsTo
    {
        return $this->belongsTo(PieceTense::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(PieceGenre::class);
    }

    public function subGenre(): BelongsTo
    {
        return $this->belongsTo(PieceGenre::class, 'piece_sub_genre_id');
    }

    public function tone(): BelongsTo
    {
        return $this->belongsTo(PieceTone::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(PieceTheme::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['title', 'user_id'])
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50);
    }

    protected static function booted(): void
    {
        parent::booted();
        self::addGlobalScope(new PieceWithScope);
    }

    protected function casts(): array
    {
        return [
            'target_word_count' => 'integer',
            'current_word_count' => 'integer',
            'start_date' => 'date',
            'target_completion_date' => 'date',
            'completion_date' => 'date',
        ];
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: static fn($value): string => $value ?? 'new',
        );
    }

    protected function startDate(): Attribute
    {
        return $this->localizedDate();
    }

    protected function targetCompletionDate(): Attribute
    {
        return $this->localizedDate();
    }

    protected function completionDate(): Attribute
    {
        return $this->localizedDate();
    }

    protected function createdAt(): Attribute
    {
        return $this->localizedDate();
    }

    protected function updatedAt(): Attribute
    {
        return $this->localizedDate();
    }
}
