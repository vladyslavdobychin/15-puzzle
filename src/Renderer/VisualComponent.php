<?php

namespace Puzzle\Renderer;

readonly class VisualComponent
{
    /**
     * Separator for game messages
     *
     * @return string
     */
    public function messageSeparator(): string
    {
        return "+------------------------+\n";
    }

    /**
     * Border of a tile
     *
     * @param int|null $tile
     * @return string
     */
    public function tile(?int $tile): string
    {
        $display = $tile === null ? "  " : sprintf('%2d', $tile);
        return "| {$display} ";
    }

    /**
     * Empty space before and after the board
     *
     * @return string
     */
    public function emptySpace(): string
    {
        return "\n" . "\n";
    }
}
