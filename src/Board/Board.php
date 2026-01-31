<?php

namespace Puzzle\Board;

use RuntimeException;

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

    public function moveTile(int $number): bool
    {
        $tilePosition = $this->findPosition($number);
        $emptyPosition = $this->findPosition(null);

        if (!$tilePosition->isAdjacent($emptyPosition)) {
            return false;
        }

        $this->swap($tilePosition, $emptyPosition);
        return true;
    }

    /**
     * Finds position of a provided number on the board.
     * If null provided, will return the position of the empty tile.
     *
     * @param int|null $tile
     * @return Position
     */
    private function findPosition(?int $tile): Position
    {
        foreach ($this->tiles as $rowNumber => $row) {
            foreach ($row as $columnNumber => $value) {
                if ($value === $tile) {
                    return new Position($rowNumber, $columnNumber);
                }
            }
        }

        throw new RuntimeException("Tile not found: $tile");
    }

    private function swap(Position $pos1, Position $pos2): void
    {
        if (!$pos1->isAdjacent($pos2)) {
            throw new RuntimeException("Only adjacent tiles could be swapped");
        }

        $temp = $this->tiles[$pos1->rowNumber][$pos1->columnNumber];
        $this->tiles[$pos1->rowNumber][$pos1->columnNumber] = $this->tiles[$pos2->rowNumber][$pos2->columnNumber];
        $this->tiles[$pos2->rowNumber][$pos2->columnNumber] = $temp;
    }

    /**
     * Returns an array of tile numbers that can currently be moved
     *
     * @return array<int>
     */
    public function getMovableTiles(): array
    {
        $emptyPosition = $this->findPosition(null);
        $movableTiles = [];

        foreach ($this->tiles as $rowNumber => $row) {
            foreach ($row as $columnNumber => $tile) {
                if ($tile !== null) {
                    $tilePosition = new Position($rowNumber, $columnNumber);
                    if ($tilePosition->isAdjacent($emptyPosition)) {
                        $movableTiles[] = $tile;
                    }
                }
            }
        }

        return $movableTiles;
    }

    public function isSolved(): bool
    {
        $expected = [
            [1, 2, 3, 4],
            [5, 6, 7, 8],
            [9, 10, 11, 12],
            [13, 14, 15, null]
        ];

        return $this->tiles === $expected;
    }

}
