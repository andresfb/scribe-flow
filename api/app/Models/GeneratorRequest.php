<?php

namespace App\Models;

use App\Enums\GeneratorStatus;
use App\Enums\GeneratorType;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $status
 * @property ?string $service
 * @property ?string $model
 * @property ?string $prompt
 * @property int $total_tokens
 * @property ?array $request
 * @property ?array $response
 * @property ?CarbonImmutable $deleted_at
 * @property ?CarbonImmutable $created_at
 * @property ?CarbonImmutable $updated_at
 */
class GeneratorRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'type',
        'status',
        'service',
        'model',
        'prompt',
        'total_tokens',
        'request',
        'response',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'request' => 'array',
            'response' => 'array',
            'total_tokens' => 'integer',
            'type' => GeneratorType::class,
            'status' => GeneratorStatus::class,
        ];
    }
}
