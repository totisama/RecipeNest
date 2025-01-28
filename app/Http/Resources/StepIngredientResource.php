<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StepIngredientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image = $this->media->first() ? $this->media->first()->getFullUrl() : '';

        return [
            'id' => $this->id,
            'name' => $this->name,
            'amount' => $this->pivot->amount,
            'image' => $image,
            'unit' => $this->pivot->unit,
        ];
    }
}
