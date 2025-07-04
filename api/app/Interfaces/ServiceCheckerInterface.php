<?php

namespace App\Interfaces;

interface ServiceCheckerInterface
{
    public function isAvailable(): bool;
}
