<?php

require_once 'vendor/autoload.php';

use Puzzle\Board\BoardFactory;
use Puzzle\Board\BoardShuffler;
use Puzzle\Game\Game;
use Puzzle\Game\Tutorial;
use Puzzle\InputHandler\InputHandler;
use Puzzle\Renderer\Renderer;
use Puzzle\Renderer\VisualComponent;

$renderer = new Renderer(
    new VisualComponent()
);
$inputHandler = new InputHandler();
$boardFactory = new BoardFactory(
    new BoardShuffler()
);

$tutorial = new Tutorial(
    $renderer,
    $inputHandler,
    $boardFactory
);

if ($tutorial->shouldShow()) {
    $tutorial->run();
}

$game = new Game(
    $boardFactory->createShuffled(),
    $renderer,
    $inputHandler
);

$game->start();
