<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255',
            'room_type'       => 'nullable|string|max:255',
            'description'     => 'nullable|string',
            'price_per_night' => 'nullable|numeric|min:0',
            'max_guests'      => 'nullable|integer|min:1|max:20',
            'amenities'       => 'nullable|string',
            'image_url'       => 'nullable|string|max:500',
            'badge_text'      => 'nullable|string|max:50',
            'badge_color'     => 'nullable|string|max:20',
            'sort_order'      => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'Room name is required.',
            'price_per_night.numeric' => 'Price must be a valid number.',
            'max_guests.max'          => 'Maximum guests cannot exceed 20.',
        ];
    }

    public function amenitiesArray(): array
    {
        return array_values(array_filter(
            array_map('trim', explode(',', $this->input('amenities', '')))
        ));
    }
}
