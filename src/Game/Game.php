<?php

namespace Puzzle\Game;

use Puzzle\Board\Board;
use Puzzle\Board\BoardFactory;
use Puzzle\Input\InputCommand;
use Puzzle\Input\ParsedInput;
use Puzzle\Input\InputHandler;
use Puzzle\Input\InputParser;
use Puzzle\Renderer\Renderer;

class Game
{
    private Board $board;
    private Renderer $renderer;
    private InputHandler $inputHandler;
    private InputParser $inputParser;
    private BoardFactory $boardFactory;

    public function __construct(
        Board $board,
        Renderer $renderer,
        InputHandler $inputHandler,
        InputParser $inputParser,
        BoardFactory $boardFactory
    ) {
        $this->board = $board;
        $this->renderer = $renderer;
        $this->inputHandler = $inputHandler;
        $this->inputParser = $inputParser;
        $this->boardFactory = $boardFactory;
    }

    /**
     * @return void
     */
    public function start(): void
    {
        $showInitialPrompt = true;
        $moveCount = 0;

        while (true) {
            $this->renderer->renderBoard($this->board);

            if ($this->board->isSolved()) {
                $this->renderer->showWin($moveCount);
                break;
            }

            if ($showInitialPrompt) {
                $this->renderer->showMessage("Enter tile number to move (or 'help' for commands): ");
                $showInitialPrompt = false;
            }

            $input = $this->getPlayerInput();

            if ($input->isCommand()) {
                $shouldQuit = $this->handleCommand($input->command, $moveCount);

                if ($shouldQuit) {
                    break;
                }

                if ($input->command === 'restart') {
                    $moveCount = 0;
                }

                continue;
            }

            if (!$this->board->moveTile($input->tileNumber)) {
                $this->renderer->showInvalidMove();
                continue;
            }

            $moveCount++;
            echo "\n";
        }
    }

    /**
     * @return ParsedInput
     */
    private function getPlayerInput(): ParsedInput
    {
        while (true) {
            $input = $this->inputHandler->readLine();
            $parsed = $this->inputParser->parse($input);

            if ($parsed === null) {
                $this->renderer->showInvalidInput();
                continue;
            }

            return $parsed;
        }
    }

    /**
     * @param string $command
     * @param int $moveCount
     * @return bool Returns true if game should quit
     */
    private function handleCommand(string $command, int $moveCount): bool
    {
        switch ($command) {
            case InputCommand::RESTART:
                $this->board = $this->boardFactory->createShuffled();
                return false;

            case InputCommand::EXIT:
                $this->renderer->showGoodbye();
                return true;

            case InputCommand::HELP:
                $this->renderer->showHelp();
                return false;

            case InputCommand::MOVES:
                $this->renderer->showMoveCount($moveCount);
                return false;

            default:
                $this->renderer->showInvalidInput();
                return false;
        }
    }
}
