<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use App\Enums\BookableType;
use Illuminate\Contracts\Validation\DataAwareRule;
use App\Models\Aircraft;
use App\Models\Exam;

class CreateBookingValidationRule implements ValidationRule, DataAwareRule
{
    protected array $data = [];

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $bookableType = $this->data['bookable_type'] ?? null; // bookable type from the request
        
        if (empty($value)) {
            return;
        }

        $exists = match($bookableType) {
            BookableType::AIRCRAFT->value, BookableType::LESSON->value => Aircraft::isServiceable()->where('id', $value)->exists(),// checks serviceable aircraft id exists in the database
            BookableType::EXAM->value => Exam::query()->where('id', $value)->exists(), // checks exam id exists in the database
            default => false,
        };

        if (! $exists) {
            $fail("The selected {$bookableType} does not exist."); // failuyre message if bookable type does not exist
        }
    }
}
