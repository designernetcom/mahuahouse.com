<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class RoomResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'room_type'       => $this->room_type,
            'filter_category' => Str::slug($this->room_type ?? ''),
            'description'     => $this->description,
            'price_per_night' => (float) $this->price_per_night,
            'max_guests'      => $this->max_guests,
            'amenities'       => $this->amenities ?? [],
            'image_url'       => $this->image_url,
            'badge_text'      => $this->badge_text,
            'badge_color'     => $this->badge_color ?? '#DAA520',
            'is_featured'     => (bool) $this->is_featured,
            'is_active'       => (bool) $this->is_active,
            'sort_order'      => $this->sort_order,
        ];
    }
}
