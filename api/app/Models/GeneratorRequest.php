<?php

namespace App\Models;

use App\Enums\GeneratorStatus;
use App\Enums\GeneratorType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $status
 * @property string $service
 * @property string $model
 * @property int $total_tokens
 * @property array $request
 * @property array $content
 * @property array $response
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
        'total_tokens',
        'request',
        'content',
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
            'content' => 'array',
            'response' => 'array',
            'total_tokens' => 'integer',
            'type' => GeneratorType::class,
            'status' => GeneratorStatus::class,
        ];
    }
}
