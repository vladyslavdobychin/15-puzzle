<?php

namespace Tests\Board;

use PHPUnit\Framework\TestCase;
use Puzzle\Board\Board;
use Puzzle\Board\BoardConfig;

class BoardTest extends TestCase
{
    public function testBoardInitializesWithSolvedState(): void
    {
        $board = new Board(BoardConfig::SOLVED);

        $this->assertTrue($board->isSolved());
        $this->assertEquals(BoardConfig::SOLVED, $board->getTiles());
    }

    public function testMovingValidMovableTile(): void
    {
        // Board with tile 15 adjacent to empty space
        $board = new Board(BoardConfig::ONE_MOVE_AWAY);

        $this->assertFalse($board->isSolved());

        // Move tile 15 into the empty space
        $result = $board->moveTile(15);

        $this->assertTrue($result, 'Should successfully move tile 15');
        $this->assertTrue($board->isSolved(), 'Board should be solved after moving tile 15');
    }

    public function testMovingNonMovableTileReturnsFalse(): void
    {
        $board = new Board(BoardConfig::SOLVED);

        // Try to move tile 1 (top-left), which is far from empty space (bottom-right)
        $result = $board->moveTile(1);

        $this->assertFalse($result, 'Should not be able to move non-adjacent tile');
        $this->assertTrue($board->isSolved(), 'Board state should remain unchanged');
    }

    public function testGetMovableTilesReturnsCorrectTiles(): void
    {
        // In solved state, only tiles 12 and 15 are adjacent to empty space
        $board = new Board(BoardConfig::SOLVED);

        $movableTiles = $board->getMovableTiles();

        $this->assertCount(2, $movableTiles);
        $this->assertContains(12, $movableTiles);
        $this->assertContains(15, $movableTiles);
    }

    public function testMultipleMovesSolvesPuzzle(): void
    {
        $board = new Board(BoardConfig::TWO_MOVES_AWAY);

        $this->assertFalse($board->isSolved());

        // Move tile 14
        $this->assertTrue($board->moveTile(14));
        $this->assertFalse($board->isSolved());

        // Move tile 15
        $this->assertTrue($board->moveTile(15));
        $this->assertTrue($board->isSolved());
    }

    public function testBoardStateChangesAfterValidMove(): void
    {
        $board = new Board(BoardConfig::ONE_MOVE_AWAY);

        $beforeTiles = $board->getTiles();
        $board->moveTile(15);
        $afterTiles = $board->getTiles();

        $this->assertNotEquals($beforeTiles, $afterTiles);
    }

    public function testBoardStateUnchangedAfterInvalidMove(): void
    {
        $board = new Board(BoardConfig::SOLVED);

        $beforeTiles = $board->getTiles();
        // Non-adjacent tile
        $board->moveTile(1);
        $afterTiles = $board->getTiles();

        $this->assertEquals($beforeTiles, $afterTiles);
    }
}
