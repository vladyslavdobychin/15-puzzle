<?php

namespace Puzzle\Board;

class BoardConfig
{
    public const BOARD_SIZE = 4;
    public const MIN_TILE = 1;
    public const MAX_TILE = 15;

    public const SOLVED = [
        [1, 2, 3, 4],
        [5, 6, 7, 8],
        [9, 10, 11, 12],
        [13, 14, 15, null]
    ];

    public const ONE_MOVE_AWAY = [
        [1, 2, 3, 4],
        [5, 6, 7, 8],
        [9, 10, 11, 12],
        [13, 14, null, 15]
    ];

    public const TWO_MOVES_AWAY = [
        [1, 2, 3, 4],
        [5, 6, 7, 8],
        [9, 10, 11, 12],
        [13, null, 14, 15]
    ];

}