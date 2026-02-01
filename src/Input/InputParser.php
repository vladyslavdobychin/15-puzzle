<?php

namespace Puzzle\Input;

use Puzzle\Board\BoardConfig;

class InputParser
{
    private const COMMANDS = [
        InputCommand::RESTART,
        InputCommand::EXIT,
        InputCommand::HELP,
        InputCommand::MOVES,
        InputCommand::HINT,
    ];

    /**
     * Parses user input and returns a ParsedInput object
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
     * Returns list of available commands
     *
     * @return array
     */
    public function getAvailableCommands(): array
    {
        return self::COMMANDS;
    }
}
