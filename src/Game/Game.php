<?php

namespace Puzzle\Game;

use Puzzle\Board\Board;
use Puzzle\Board\BoardConfig;
use Puzzle\InputHandler\InputHandler;
use Puzzle\Renderer\Renderer;

class Game
{
    private Board $board;
    private Renderer $renderer;
    private InputHandler $inputHandler;

    public function __construct(Board $board, Renderer $renderer, InputHandler $inputHandler)
    {
        $this->board = $board;
        $this->renderer = $renderer;
        $this->inputHandler = $inputHandler;
    }

    /**
     * @return void
     */
    public function start(): void
    {
        $showInitialPrompt = true;
        $moveCount = 0;

        // TODO: DO I need the while loop here?
        while (true) {
            $this->renderer->renderBoard($this->board);

            if ($this->board->isSolved()) {
                $this->renderer->showWin($moveCount);
                break;
            }

            if ($showInitialPrompt) {
                $this->renderer->showMessage("Enter tile number to move: ");
                $showInitialPrompt = false;
            }

            $tile = $this->getTileInput();

            if (!$this->board->moveTile($tile)) {
                $this->renderer->showInvalidMove();
                continue;
            }

            $moveCount++;

            echo "\n";
        }
    }

    /**
     * @return int
     */
    private function getTileInput(): int
    {
        while (true) {
            $input = $this->inputHandler->readLine();

            if (!is_numeric($input)) {
                $this->renderer->showInvalidInput();
                continue;
            }

            $tile = (int)$input;

            if ($tile < BoardConfig::MIN_TILE || $tile > BoardConfig::MAX_TILE) {
                $this->renderer->showInvalidTile();
                continue;
            }

            return $tile;
        }
    }
}