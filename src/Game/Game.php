<?php

namespace Puzzle\Game;

use Puzzle\Board\Board;
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

    public function start(): void
    {
        $showInitialPrompt = true;

        while (true) {
            $this->renderer->renderBoard($this->board);

            if ($this->board->isSolved()) {
                $this->renderer->showWin();
                break;
            }

            if ($showInitialPrompt) {
                $this->renderer->showMessage("Enter tile number to move: ");
                $showInitialPrompt = false;
            }

            $tile = $this->inputHandler->getUserInput();

            if (!$this->board->moveTile($tile)) {
                $this->renderer->showInvalidMove();
                continue;
            }

            echo "\n";
        }
    }
}