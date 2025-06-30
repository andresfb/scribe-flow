<?php

namespace App\Http\QueryBuilders\api\v1\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class DateFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): void
    {
        // if a single date was passed: filter[created_at]=2025-06-20
        if (! is_array($value)) {
            $query->where($property, '>=', $value);

            return;
        }

        // if an array with from_date/to_date:
        // filter[created_at][from_date]=2025-06-01
        // filter[created_at][to_date]=2025-06-30
        if (isset($value['from_date'], $value['to_date'])) {
            $query->whereBetween($property, [
                $value['from_date'],
                $value['to_date'],
            ]);
        }
    }
}
