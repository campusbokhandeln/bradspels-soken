<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GameGateway
{
    protected $limit = 50;

    public function limit(int $limit) : self
    {
        $this->limit = $limit;

        return $this;
    }

    public function search(string $searchTerm) : Collection
    {
        $games = Http::get(config('services.boardgame_atlas.api_url') . '?limit=' . $this->limit . '&client_id=' . config('services.boardgame_atlas.id') .'&name=' . $searchTerm)->json();

        return $this->castToCollection($games);
    }

    public function random() : Collection
    {
        $games = Http::get(config('services.boardgame_atlas.api_url') . '?random=true&client_id=' . config('services.boardgame_atlas.id'))->json();

        return $this->castToCollection($games);
    }

    protected function castToCollection(array $games) : Collection
    {
        return collect($games['games'])
            ->map(fn ($game) => new Game($game['name'], $game['price'], $game['description'], $game['image_url'], $game['url']));
    }
}
