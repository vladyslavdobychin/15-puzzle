<?php

namespace Tests\Board;

use PHPUnit\Framework\TestCase;
use Puzzle\Board\Board;
use Puzzle\Board\BoardConfig;
use Puzzle\Board\BoardShuffler;

class BoardShufflerTest extends TestCase
{
    public function testShuffleChangesBoardState(): void
    {
        $shuffler = new BoardShuffler();
        $board = new Board(BoardConfig::SOLVED);

        $originalTiles = $board->getTiles();

        $shuffler->shuffle($board, 50);

        $shuffledTiles = $board->getTiles();

        // After 50 moves, board should be different from solved state
        $this->assertNotEquals($originalTiles, $shuffledTiles);
    }

    public function testShuffledBoardIsNotSolved(): void
    {
        $shuffler = new BoardShuffler();
        $board = new Board(BoardConfig::SOLVED);

        $shuffler->shuffle($board, 100);

        // Very unlikely to be solved after 100 random moves
        $this->assertFalse($board->isSolved());
    }
}
