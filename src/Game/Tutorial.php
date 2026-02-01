<?php

namespace Puzzle\Game;

use Puzzle\Board\BoardFactory;
use Puzzle\Board\BoardShuffler;
use Puzzle\Input\InputHandler;
use Puzzle\Input\InputParser;
use Puzzle\Renderer\Renderer;

class Tutorial
{
    private Renderer $renderer;
    private InputHandler $inputHandler;
    private BoardFactory $boardFactory;

    public function __construct(
        Renderer $renderer,
        InputHandler $inputHandler,
        BoardFactory $boardFactory
    ) {
        $this->renderer = $renderer;
        $this->inputHandler = $inputHandler;
        $this->boardFactory = $boardFactory;
    }

    /**
     * Asks the user if they want to play the tutorial
     *
     * @return bool
     */
    public function shouldShow(): bool
    {
        $this->renderer->showMessage("Would you like to play the tutorial? (y/n)");
        $response = strtolower($this->inputHandler->readLine());

        return $response === 'y' || $response === 'yes';
    }

    /**
     * Runs the tutorial with an almost-solved board
     *
     * @return void
     */
    public function run(): void
    {
        $this->renderer->showMessage(
            "Welcome to 15 Puzzle!\n\n" .
            "The goal is to arrange tiles in order from 1-15,\n" .
            "with the empty space in the bottom-right corner.\n\n" .
            "You can only move tiles adjacent to the empty space.\n" .
            "Enter the number of the tile you want to move."
        );

        $this->renderer->showMessage(
            "Let's practice! You can see a sequence of tiles which is *almost* solved.\nAll of them arranged correctly except number 15. Move number 15 to solve the puzzle."
        );

        $tutorialBoard = $this->boardFactory->createOneMoveAway();
        $inputParser = new InputParser();
        $boardFactory = new BoardFactory(
            new BoardShuffler()
        );
        $tutorialGame = new Game(
            $tutorialBoard,
            $this->renderer,
            $this->inputHandler,
            $inputParser,
            $boardFactory
        );
        $tutorialGame->start();

        $this->renderer->showMessage(
            "Great job! You've completed the tutorial.\n" .
            "Now let's play the real game!"
        );
    }
}
