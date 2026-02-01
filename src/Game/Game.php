<?php

namespace Puzzle\Game;

use Puzzle\Board\Board;
use Puzzle\Board\BoardFactory;
use Puzzle\Input\InputCommand;
use Puzzle\Input\InputHandler;
use Puzzle\Input\InputParser;
use Puzzle\Input\ValueObjects\ParsedInput;
use Puzzle\Persistence\SaveManager;
use Puzzle\Renderer\Renderer;

class Game
{
    private bool $showInitialPrompt = true;
    private int $moveCount;
    private Board $board;
    private Renderer $renderer;
    private InputHandler $inputHandler;
    private InputParser $inputParser;
    private BoardFactory $boardFactory;
    private SaveManager $saveManager;


    public function __construct(
        Board $board,
        Renderer $renderer,
        InputHandler $inputHandler,
        InputParser $inputParser,
        BoardFactory $boardFactory,
        SaveManager $saveManager,
        int $moveCount = 0
    ) {
        $this->board = $board;
        $this->renderer = $renderer;
        $this->inputHandler = $inputHandler;
        $this->inputParser = $inputParser;
        $this->boardFactory = $boardFactory;
        $this->saveManager = $saveManager;
        $this->moveCount = $moveCount;
    }

    /**
     * @return void
     */
    public function start(): void
    {
        while (true) {
            $this->renderer->renderBoard($this->board);

            if ($this->board->isSolved()) {
                $this->renderer->showWin($this->moveCount);
                $this->saveManager->clear();
                break;
            }

            if ($this->showInitialPrompt) {
                $this->renderer->showMessage("Enter tile number to move (or 'help' for commands): ");
                $this->showInitialPrompt = false;
            }

            $input = $this->getPlayerInput();

            if ($input->isCommand()) {
                $shouldQuit = $this->handleCommand($input->command, $this->moveCount);

                if ($shouldQuit) {
                    break;
                }

                continue;
            }

            if (!$this->board->moveTile($input->tileNumber)) {
                $this->renderer->showInvalidMove();
                continue;
            }

            $this->moveCount++;
            $this->saveManager->save($this->board, $this->moveCount);
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
                $this->restart();
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

    /**
     * @return void
     */
    private function restart(): void
    {
        $this->renderer->showMessage("Starting a new game...");
        $this->board = $this->boardFactory->createShuffled();
        $this->moveCount = 0;
        $this->saveManager->clear();
    }
}
