<?php

require_once 'vendor/autoload.php';

use Puzzle\Board\Board;
use Puzzle\Board\BoardFactory;
use Puzzle\Board\BoardShuffler;
use Puzzle\Game\Game;
use Puzzle\Game\Tutorial;
use Puzzle\Input\InputHandler;
use Puzzle\Input\InputParser;
use Puzzle\HomeScreen\HomeScreen;
use Puzzle\HomeScreen\MenuChoice;
use Puzzle\Persistence\SaveManager;
use Puzzle\Renderer\Renderer;
use Puzzle\Renderer\VisualComponent;

// Initialize dependencies
$renderer = new Renderer(new VisualComponent());
$inputHandler = new InputHandler();
$inputParser = new InputParser();
$boardFactory = new BoardFactory(new BoardShuffler());
$saveManager = new SaveManager();

// Show home screen
$homeScreen = new HomeScreen($renderer, $inputHandler, $saveManager);
$choice = $homeScreen->show();

// Handle user's choice
switch ($choice) {
    case MenuChoice::EXIT:
        $renderer->showGoodbye();
        exit(0);

    case MenuChoice::TUTORIAL:
        $tutorial = new Tutorial($renderer, $inputHandler, $boardFactory);
        $tutorial->run();

        $choice = $homeScreen->show();
        break;

    case MenuChoice::CONTINUE:
        $saveData = $saveManager->load();
        if ($saveData === null) {
            $renderer->showMessage("Could not load saved game. Starting a new game instead.");
            $choice = MenuChoice::NEW_GAME;
        }
        break;
}

if ($choice === MenuChoice::CONTINUE) {
    $saveData = $saveManager->load();
    $board = new Board($saveData->tiles);
    $game = new Game(
        $board,
        $renderer,
        $inputHandler,
        $inputParser,
        $boardFactory,
        $saveManager,
        $saveData->moveCount
    );
} else {
    $board = $boardFactory->createShuffled();
    $game = new Game(
        $board,
        $renderer,
        $inputHandler,
        $inputParser,
        $boardFactory,
        $saveManager
    );
}

$game->start();
