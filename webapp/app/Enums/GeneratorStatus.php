<?php

declare(strict_types=1);

namespace App\Enums;

enum GeneratorStatus: string
{
    case REQUESTED = 'R';
    case GENERATING = 'G';
    case COMPLETED = 'C';
    case FAILED = 'F';
}
