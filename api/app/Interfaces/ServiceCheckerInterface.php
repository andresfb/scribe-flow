<?php

declare(strict_types=1);

namespace App\Interfaces;

interface ServiceCheckerInterface
{
    public function isAvailable(): bool;
}
