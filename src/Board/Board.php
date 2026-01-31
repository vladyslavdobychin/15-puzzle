<?php

namespace Puzzle\Board;

class Board
{
    private array $tiles;

    public function __construct()
    {
        $this->tiles = [
            [1, 2, 3, 4],
            [5, 6, 7, 8],
            [9, 10, 11, 12],
            [13, 14, 15, null]
        ];
    }

    public function getTiles(): array
    {
        return $this->tiles;
    }
}
