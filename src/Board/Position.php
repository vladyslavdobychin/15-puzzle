<?php

namespace Puzzle\Board;

readonly class Position
{
    public int $rowNumber;
    public int $columnNumber;

    public function __construct(int $rowNumber, int $columnNumber)
    {
        $this->rowNumber = $rowNumber;
        $this->columnNumber = $columnNumber;
    }

    public function isAdjacent(Position $position): bool
    {
        $sameRow = $this->rowNumber === $position->rowNumber;
        $sameColumn = $this->columnNumber === $position->columnNumber;

        return ($sameRow && abs($this->columnNumber - $position->columnNumber) === 1)
            || ($sameColumn && abs($this->rowNumber - $position->rowNumber) === 1);
    }
}
