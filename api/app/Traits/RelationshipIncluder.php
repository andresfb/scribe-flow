<?php

namespace App\Traits;

trait RelationshipIncluder
{
    private function include(string $relationship): bool
    {
        $param = request()->query('include');

        if (! isset($param)) {
            return false;
        }

        $includeValues = explode(',', mb_strtolower($param));

        return in_array(
            needle: mb_strtolower($relationship),
            haystack: $includeValues,
            strict: true
        );
    }
}
