<?php

namespace Puzzle\Renderer;

readonly class VisualComponent
{
    public function messageSeparator(): string
    {
        return "+------------------------+\n";
    }

    public function tile(?int $tile): string
    {
        $display = $tile === null ? "  " : sprintf('%2d', $tile);
        return "| {$display} ";
    }
}