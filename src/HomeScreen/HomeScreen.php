<?php

namespace Puzzle\HomeScreen;

use Puzzle\Input\InputHandler;
use Puzzle\Persistence\SaveManager;
use Puzzle\Renderer\Renderer;

class HomeScreen
{
    private Renderer $renderer;
    private InputHandler $inputHandler;
    private SaveManager $saveManager;

    public function __construct(
        Renderer $renderer,
        InputHandler $inputHandler,
        SaveManager $saveManager
    ) {
        $this->renderer = $renderer;
        $this->inputHandler = $inputHandler;
        $this->saveManager = $saveManager;
    }

    /**
     * @return string One of MenuChoice constants
     */
    public function show(): string
    {
        while (true) {
            $this->displayMenu();
            $choice = $this->getChoice();

            if ($choice !== null) {
                return $choice;
            }

            $this->renderer->showMessage('Invalid input, pick an option between 1 and 4');
        }
    }

    /**
     * Displays the menu options
     *
     * @return void
     */
    private function displayMenu(): void
    {
        $hasSave = $this->saveManager->exists();
        //TODO: ugly
        echo "\n";
        echo "╔════════════════════════════╗\n";
        echo "║       15 PUZZLE GAME       ║\n";
        echo "╚════════════════════════════╝\n";
        echo "\n";
        echo "1. New Game\n";

        if ($hasSave) {
            echo "2. Continue Game\n";
        }

        echo "3. Tutorial\n";
        echo "4. Exit\n";
        echo "\n";
        echo "Enter your choice: ";
    }

    /**
     * Gets and validates user's menu choice
     *
     * @return string|null Returns MenuChoice constant or null if invalid
     */
    private function getChoice(): ?string
    {
        $input = $this->inputHandler->readLine();
        $hasSave = $this->saveManager->exists();

        return match ($input) {
            '1' => MenuChoice::NEW_GAME,
            '2' => $hasSave ? MenuChoice::CONTINUE : null,
            '3' => MenuChoice::TUTORIAL,
            '4' => MenuChoice::EXIT,
            default => null,
        };
    }
}