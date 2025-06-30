<?php

namespace App\Models;

use App\Traits\DateAttributable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int $id
 * @property int $user_id
 * @property int $piece_type_id
 * @property int $piece_status_id
 * @property string $slug
 * @property string $title
 * @property string $synopsis
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
    use HasFactory;
    use HasSlug;
    use SoftDeletes;
    use DateAttributable;

    protected $fillable = [
        'user_id',
        'piece_type_id',
        'piece_status_id',
        'slug',
        'title',
        'synopsis',
        'target_word_count',
        'current_word_count',
        'start_date',
        'target_completion_date',
        'completion_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pieceType(): BelongsTo
    {
        return $this->belongsTo(PieceType::class);
    }

    public function pieceStatus(): BelongsTo
    {
        return $this->belongsTo(PieceStatus::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
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
