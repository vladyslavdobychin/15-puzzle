<?php

namespace Puzzle\Board;

use InvalidArgumentException;

class TilesValidator
{
    /**
     * Validates that the tiles array represents a valid board state
     *
     * @param array $tiles
     * @return void
     * @throws InvalidArgumentException
     */
    public static function validate(array $tiles): void
    {
        self::validateDimensions($tiles);
        self::validateTileValues($tiles);
    }

    /**
     * Validates that the board has correct dimensions
     *
     * @param array $tiles
     * @return void
     * @throws InvalidArgumentException
     */
    private static function validateDimensions(array $tiles): void
    {
        $size = BoardConfig::BOARD_SIZE;

        if (count($tiles) !== $size) {
            throw new InvalidArgumentException(
                "Board must have exactly {$size} rows, got " . count($tiles)
            );
        }

        foreach ($tiles as $rowIndex => $row) {
            if (!is_array($row)) {
                throw new InvalidArgumentException(
                    "Row {$rowIndex} must be an array"
                );
            }

            if (count($row) !== $size) {
                throw new InvalidArgumentException(
                    "Row {$rowIndex} must have exactly {$size} columns, got " . count($row)
                );
            }
        }
    }

    /**
     * Validates that the board contains right number of tiles and a null
     *
     * @param array $tiles
     * @return void
     * @throws InvalidArgumentException
     */
    private static function validateTileValues(array $tiles): void
    {
        $foundValues = [];
        $nullCount = 0;

        foreach ($tiles as $row) {
            foreach ($row as $tile) {
                if ($tile === null) {
                    $nullCount++;
                    continue;
                }

                if (!is_int($tile)) {
                    throw new InvalidArgumentException(
                        "Tile value must be an integer or null, got " . gettype($tile)
                    );
                }

                if ($tile < BoardConfig::MIN_TILE || $tile > BoardConfig::MAX_TILE) {
                    throw new InvalidArgumentException(
                        "Tile value must be between " . BoardConfig::MIN_TILE .
                        " and " . BoardConfig::MAX_TILE . ", got {$tile}"
                    );
                }

                if (in_array($tile, $foundValues)) {
                    throw new InvalidArgumentException(
                        "Duplicate tile value found: {$tile}"
                    );
                }

                $foundValues[] = $tile;
            }
        }

        if ($nullCount !== 1) {
            throw new InvalidArgumentException(
                "Board must have exactly one empty tile (null), got {$nullCount}"
            );
        }

        $expectedCount = BoardConfig::MAX_TILE - BoardConfig::MIN_TILE + 1;
        if (count($foundValues) !== $expectedCount) {
            throw new InvalidArgumentException(
                "Board must have exactly {$expectedCount} numbered tiles, got " . count($foundValues)
            );
        }

        sort($foundValues);
        for ($i = BoardConfig::MIN_TILE; $i <= BoardConfig::MAX_TILE; $i++) {
            if (!in_array($i, $foundValues)) {
                throw new InvalidArgumentException(
                    "Missing tile value: {$i}"
                );
            }
        }
    }
}