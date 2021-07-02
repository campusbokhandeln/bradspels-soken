<?php

namespace Tests\Feature\Services;

use Tests\TestCase;
use App\Services\Game;
use App\Services\GameGateway;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameGatewayTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function it_can_get_games_from_the_api()
    {
        $gateway = new GameGateway();

        $results = $gateway->search('pokemon');

        $this->assertGreaterThan(1, $results->count());
        $this->assertInstanceOf(Game::class, $results->first());
    }

    /** @test */
    public function it_can_limit_the_results()
    {
        $gateway = new GameGateway();

        $tenResults = $gateway->limit(10)->search('pokemon');
        $fiveResults = $gateway->limit(5)->search('pokemon');

        $this->assertCount(10, $tenResults);
        $this->assertCount(5, $fiveResults);
    }

    /** @test */
    public function it_can_get_a_random_game()
    {
        $gateway = new GameGateway();

        $game = $gateway->random();
        dd($game);
        $this->assertInstanceOf(Game::class, $game);
    }
}
