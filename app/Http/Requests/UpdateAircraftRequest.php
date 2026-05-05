<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAircraftRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) Auth::user()?->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|string|max:255',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'registration' => 'required|string|max:7|unique:aircraft,registration,' . $this->route('aircraft')?->id,
            'rental_price_per_hour' => 'required|numeric|min:0|max:1000',
            'in_service' => 'required|boolean',
            'current_hours' => 'required|integer|min:0|max:20000',
            'image_url' => 'nullable|url',
        ];
    }
}
