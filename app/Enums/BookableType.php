<?php

declare(strict_types=1);

namespace App\Enums;

enum BookableType: string
{
    case AIRCRAFT = 'aircraft';
    case EXAM = 'exam';
    case LESSON = 'lesson';

    public function label(): string
    {
        return match ($this) {
            self::AIRCRAFT => 'Aircraft',
            self::EXAM => 'Exam',
            self::LESSON => 'Lesson',
        };
    }
}
