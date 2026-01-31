<?php

require_once 'vendor/autoload.php';

use Puzzle\Board\Board;
use Puzzle\InputHandler\InputHandler;
use Puzzle\Renderer\Renderer;
use Puzzle\Renderer\VisualComponent;

$board = new Board();
$renderer = new Renderer(
    new VisualComponent()
);
$inputHandler = new InputHandler();

$showInitialPrompt = true;

while (true) {
    $renderer->renderBoard($board);

    if ($board->isSolved()) {
        $renderer->showWin();
        break;
    }

    if ($showInitialPrompt) {
        $renderer->showMessage("Enter tile number to move: ");
        $showInitialPrompt = false;
    }
    $input = $inputHandler->getUserInput();

    if (!$board->moveTile($input)) {
       $renderer->showInvalidMove();
        continue;
    }

    echo "\n";
}
