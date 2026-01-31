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
            [13, 14, null, 15]
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

        throw new \RuntimeException("Tile not found: $tile");
    }

    private function swap(Position $pos1, Position $pos2): void
    {
        $temp = $this->tiles[$pos1->rowNumber][$pos1->columnNumber];
        $this->tiles[$pos1->rowNumber][$pos1->columnNumber] = $this->tiles[$pos2->rowNumber][$pos2->columnNumber];
        $this->tiles[$pos2->rowNumber][$pos2->columnNumber] = $temp;
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
