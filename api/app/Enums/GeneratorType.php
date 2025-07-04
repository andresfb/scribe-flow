<?php

declare(strict_types=1);

namespace App\Enums;

enum GeneratorType: string
{
    case SYNOPSIS = 'synopsis';
    case OUTLINE = 'outline';
    case PARAGRAPH = 'paragraph';
    case BEATS = 'beats';
    case SCENE = 'scene';
    case CHAPTER = 'chapter';
    case SECTION = 'section';
    case CHARACTER = 'character';
    case SETTING = 'setting';
    case EVENT = 'event';
}
