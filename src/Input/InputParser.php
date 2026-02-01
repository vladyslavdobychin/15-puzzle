<?php

namespace Puzzle\Input;

use Puzzle\Board\BoardConfig;
use Puzzle\Input\ValueObjects\ParsedInput;

class InputParser
{
    private const COMMANDS = [
        InputCommand::RESTART,
        InputCommand::EXIT,
        InputCommand::HELP,
        InputCommand::MOVES,
    ];

    /**
     *
     * @param string $input
     * @return ParsedInput|null Returns null if input is invalid
     */
    public function parse(string $input): ?ParsedInput
    {
        $input = strtolower(trim($input));

        if (in_array($input, self::COMMANDS, true)) {
            return new ParsedInput(command: $input);
        }

        if (!is_numeric($input)) {
            return null;
        }

        $tileNumber = (int)$input;

        if ($tileNumber < BoardConfig::MIN_TILE || $tileNumber > BoardConfig::MAX_TILE) {
            return null;
        }

        return new ParsedInput(tileNumber: $tileNumber);
    }

    /**
     * @return array
     */
    public function getAvailableCommands(): array
    {
        return self::COMMANDS;
    }
}
