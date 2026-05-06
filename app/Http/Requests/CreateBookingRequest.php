<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Enums\BookableType;
use App\Rules\CreateBookingValidationRule;

class CreateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $bookableType = $this->input('bookable_type'); // bookable type from the request
        
        $isAircraftOrLesson = in_array($bookableType, [
            BookableType::AIRCRAFT->value,
            BookableType::LESSON->value
        ]); // true if the bookable type is either aircraft of lesson

        $isAircraftLessonOrExam = in_array($bookableType, [
            BookableType::AIRCRAFT->value,
            BookableType::LESSON->value,
            BookableType::EXAM->value
        ]); // true if the bookable type is either aircraft of lesson or exam

        $isExam = $bookableType === BookableType::EXAM->value; // true if the bookable type is an exam
        $isLesson = $bookableType === BookableType::LESSON->value; // specific to lesson because it needs an instructor

        return [
            'bookable_type' => [
                'required',
                Rule::enum(BookableType::class)
            ], // bookable type from the request

            'bookable_id' => [
                Rule::requiredIf($isAircraftLessonOrExam), // required if the bookable type is either aircraft of lesson or exam
                new CreateBookingValidationRule(), // validate the bookable id
            ],

            'instructor_id' => [
                Rule::requiredIf($isLesson),
                'nullable',
                'exists:instructors,id',
            ],

            'user_id' => [
                Rule::requiredIf(fn () => Auth::user()?->is_admin),
                'required',
                'exists:users,id',
            ],

            'start_date' => [
                'required',
                'date',
                'after_or_equal:today'
            ],

            'start_time' => [
                'required',
                'date_format:H:i'
            ],

            'duration_hours' => [
                Rule::requiredIf($isAircraftOrLesson),
                Rule::excludeIf($isExam),
                'nullable',
                'numeric',
                'min:0.25',
                'max:24',
            ],

            'total_price' => [
                'required',
                'numeric',
                'min:0',
                'max:100000',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'bookable_id.required' => 'Please select an aircraft or lesson.',
            'bookable_id.exists' => 'The selected bookable does not exist.',
            'instructor_id.required' => 'Please select an instructor for your lesson.',
            'instructor_id.exists' => 'The selected instructor does not exist.',
            'start_date.required' => 'Please select a start date.',
            'start_date.after_or_equal' => 'The start date must be today or later.',
            'start_time.required' => 'Please select a start time.',
            'duration_hours.required' => 'Please enter a duration in hours.',
            'duration_hours.numeric' => 'Duration must be a number.',
            'duration_hours.min' => 'Duration must be at least 0.25 hours (15 minutes).',
            'duration_hours.max' => 'Duration may not exceed 24 hours.',
        ]; // custom messages for validator errors
    }
}
