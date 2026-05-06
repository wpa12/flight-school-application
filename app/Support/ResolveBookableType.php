<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\BookableType;
use App\Models\Aircraft;
use App\Models\Exam;
use App\Models\Lesson;

class ResolveBookableType
{
    /** Resolves a bookable type to a classname */
    public static function resolveBookableType(string $bookableType): string
    {
        return match ($bookableType) {
            BookableType::AIRCRAFT->value => Aircraft::class,
            BookableType::EXAM->value => Exam::class,
            BookableType::LESSON->value => Lesson::class,
            default => '',
        };
    }
}
