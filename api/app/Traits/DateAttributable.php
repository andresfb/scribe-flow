<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

trait DateAttributable
{
    protected function localizedDate(): Attribute
    {
        return Attribute::make(
            get: static function (Carbon|string|null $value) {
                if ($value === null) {
                    return null;
                }

                if ($value === '') {
                    return null;
                }

                return Carbon::parse($value)->timezone(
                    auth()->user()->timezone ?? Config::string('constants.default_timezone')
                );
            },
        );
    }
}
