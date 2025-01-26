<?php

namespace App\Services;

use Http;

enum Endpoints: string
{
    case SPECIFIC = 'specific_endpoint';
    case LIST = 'list_endpoint';
}

class TastyService
{
    protected string $endpoint;

    protected string $apiKey;

    public function __construct(Endpoints $endpoint = Endpoints::LIST)
    {
        $this->endpoint = config("services.tasty.{$endpoint->value}", 'services.tasty.list_endpoint');
        $this->apiKey = config('services.tasty.key', '');
    }

    public function getRecipes()
    {
        try {
            $response = Http::withHeaders([
                'x-rapidapi-key' => $this->apiKey,
            ])->get($this->endpoint);

            if (! $response->successful()) {
                throw new \Exception('Failed to fetch recipes');
            }
        } catch (\Exception $e) {
            return [];
        }

        $response = json_decode($response->getBody()->getContents());
        $recipes = $this->formatData($response->results);

        return $recipes;
    }

    private function formatData(array $data): array
    {
        $recipes = [];

        foreach ($data as $recipe) {
            $recipes[] = [
                'id' => $recipe->id,
                'title' => $recipe->name,
                'total_time' => $recipe->total_time_minutes ? $this->formatTime($recipe->total_time_minutes) : 'N/A',
                'steps' => count($recipe->instructions),
                'description' => $recipe->description,
                'image' => $recipe->thumbnail_url,
            ];
        }

        return $recipes;
    }

    private function formatTime(?int $time = null)
    {
        $hours = floor($time / 60);
        $minutes = $time % 60;

        return ($hours > 0 ? $hours.'h ' : '').($minutes > 0 ? $minutes.'m' : '');
    }
}
