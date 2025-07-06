<?php

declare(strict_types=1);

namespace App\Models\Pieces;

use App\Models\Lists\Character;
use App\Models\Lists\Genre;
use App\Models\Lists\Pace;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\PieceType;
use App\Models\Lists\Pov;
use App\Models\Lists\Setting;
use App\Models\Lists\Storyline;
use App\Models\Lists\Style;
use App\Models\Lists\Tense;
use App\Models\Lists\Theme;
use App\Models\Lists\Timeline;
use App\Models\Lists\Tone;
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
 * @property int $pov_id
 * @property int $tense_id
 * @property int $genre_id
 * @property int $sub_genre_id
 * @property int $tone_id
 * @property int $theme_id
 * @property int $character_id
 * @property int $piece_id
 * @property int $setting_id
 * @property int $timeline_id
 * @property int $storyline_id
 * @property int $style_id
 * @property string $slug
 * @property string $title
 * @property string $idea
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
final class Piece extends Model
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
        'pov_id',
        'tense_id',
        'genre_id',
        'sub_genre_id',
        'tone_id',
        'theme_id',
        'character_id',
        'piece_id',
        'setting_id',
        'timeline_id',
        'storyline_id',
        'style_id',
        'title',
        'genre',
        'sub_genre',
        'idea',
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
        return $this->belongsTo(PieceType::class, 'piece_type_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PieceStatus::class, 'piece_status_id', 'id');
    }

    public function pov(): BelongsTo
    {
        return $this->belongsTo(Pov::class);
    }

    public function tense(): BelongsTo
    {
        return $this->belongsTo(Tense::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function subGenre(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'sub_genre_id');
    }

    public function tone(): BelongsTo
    {
        return $this->belongsTo(Tone::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function pace(): BelongsTo
    {
        return $this->belongsTo(Pace::class);
    }

    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class);
    }

    public function timeline(): BelongsTo
    {
        return $this->belongsTo(Timeline::class);
    }

    public function storyline(): BelongsTo
    {
        return $this->belongsTo(Storyline::class);
    }

    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class);
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
            get: static fn ($value): string => $value ?? 'new',
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
