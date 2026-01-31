<?php

namespace Puzzle\Board;

class BoardFactory {
    private BoardShuffler $shuffler;

    public function __construct(BoardShuffler $shuffler) {
        $this->shuffler = $shuffler;
    }

    public function createShuffled(int $moves = 100): Board {
        $board = new Board();
        $this->shuffler->shuffle($board, $moves);
        return $board;
    }
}