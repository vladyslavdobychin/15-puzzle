<?php

require_once 'vendor/autoload.php';

use Puzzle\Board\BoardFactory;
use Puzzle\Board\BoardShuffler;
use Puzzle\Game\Game;
use Puzzle\InputHandler\InputHandler;
use Puzzle\Renderer\Renderer;
use Puzzle\Renderer\VisualComponent;

$boardFactory = new BoardFactory(new BoardShuffler());

$game = new Game(
    $boardFactory->createShuffled(),
    new Renderer(new VisualComponent()),
    new InputHandler()
);

$game->start();