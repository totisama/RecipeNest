<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $image = $this->media->first() ? $this->media->first()->getFullUrl() : '';

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $image,
        ];
    }
}
