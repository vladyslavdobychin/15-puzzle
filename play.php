<?php

require_once 'vendor/autoload.php';

use Puzzle\Board\Board;
use Puzzle\Game\Game;
use Puzzle\InputHandler\InputHandler;
use Puzzle\Renderer\Renderer;
use Puzzle\Renderer\VisualComponent;

$game = new Game(
    new Board(),
    new Renderer(new VisualComponent()),
    new InputHandler()
);

$game->start();