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
        $games = Http::get('https://api.boardgameatlas.com/api/search?limit=' . $this->limit . '&client_id=rQXWtpmku9&name=' . $searchTerm)->json();

        return collect($games['games'])
            ->map(fn ($game) => new Game($game['name'], $game['price'], $game['description'], $game['image_url'], $game['url']));
    }

    public function random() : Collection
    {
        $games = Http::get('https://api.boardgameatlas.com/api/search?random=true&limit=' . $this->limit . '&client_id=rQXWtpmku9')->json();

        return collect($games['games'])
            ->map(fn ($game) => new Game($game['name'], $game['price'], $game['description'], $game['image_url'], $game['url']));
    }
}
