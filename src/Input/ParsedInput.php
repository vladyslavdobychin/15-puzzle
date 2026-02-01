<?php

namespace Puzzle\Input;

readonly class ParsedInput
{
    public ?int $tileNumber;
    public ?string $command;

    public function __construct(
        ?int $tileNumber = null,
        ?string $command = null
    ) {
        if ($tileNumber === null && $command === null) {
            throw new \InvalidArgumentException("Either tile number or command must be provided");
        }

        if ($tileNumber !== null && $command !== null) {
            throw new \InvalidArgumentException("Cannot have both tile number and command");
        }

        $this->tileNumber = $tileNumber;
        $this->command = $command;
    }

    public function isTileMove(): bool
    {
        return $this->tileNumber !== null;
    }

    public function isCommand(): bool
    {
        return $this->command !== null;
    }
}
