<?php

namespace App\Services;

class Game
{
    public function __construct(
        public string $name,
        public string $price,
        public string $description,
        public string $image,
        public string $url
    ) {
    }
}
