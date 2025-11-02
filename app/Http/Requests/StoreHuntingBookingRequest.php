<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHuntingBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tour_name' => 'required|string|max:255',
            'hunter_name' => 'required|string|max:255',
            'guide_id' => 'required|exists:guides,id',
            'date' => 'required|date|after_or_equal:today',
            'participants_count' => 'required|integer|min:1|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'participants_count.max' => 'Максимум 10 участников на тур.',
        ];
    }

}
