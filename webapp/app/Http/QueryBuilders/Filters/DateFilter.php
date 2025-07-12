<?php

declare(strict_types=1);

namespace App\Http\QueryBuilders\Filters;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

final class DateFilter implements Filter
{
    private readonly string $timezone;

    private array $translations = [
        'created' => 'created_at',
        'updated' => 'updated_at',
    ];

    public function __construct()
    {
        $this->timezone = config('constants.default_timezone');
    }

    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $property = $this->translations[$property] ?? $property;

        // if a single date was passed: filter[created_at]=2025-06-20
        if (! is_array($value)) {
            $query->where(
                $property,
                '>=',
                CarbonImmutable::parse($value)
                    ->timezone($this->timezone)
            );

            return;
        }

        // if an array with from_date/to_date:
        // filter[created_at][from_date]=2025-06-01
        // filter[created_at][to_date]=2025-06-30
        if (isset($value['from_date'], $value['to_date'])) {
            $query->whereBetween($property, [
                CarbonImmutable::parse($value['from_date'])
                    ->startOfDay(),
                CarbonImmutable::parse($value['to_date'])
                    ->endOfDay(),
            ]);
        }
    }
}
