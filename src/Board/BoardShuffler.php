<?php

namespace Puzzle\Board;

class BoardShuffler
{
    /**
     * Shuffles the board by making random valid moves.
     * This guarantees the board remains in a solvable state.
     *
     * @param Board $board
     * @param int $numberOfMoves Number of random moves to make (default: 100)
     * @return void
     */
    public function shuffle(Board $board, int $numberOfMoves = 100): void
    {
        for ($i = 0; $i < $numberOfMoves; $i++) {
            $movableTiles = $board->getMovableTiles();

            if (empty($movableTiles)) {
                throw new \RuntimeException("No movable tiles found during shuffle");
            }

            $randomTile = $movableTiles[array_rand($movableTiles)];
            $board->moveTile($randomTile);
        }
    }
}