<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $image = $this->media->first() ? $this->media->first()->getFullUrl() : '';

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'totalTime' => $this->total_time,
            'image' => $image,
            'url' => route('recipes.show', $this->id),
            'stepsCount' => $this->steps->count(),
            'steps' => StepResource::collection($this->steps),
        ];
    }
}
