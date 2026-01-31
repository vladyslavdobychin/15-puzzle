<?php

require_once 'vendor/autoload.php';

use Puzzle\Board\Board;
use Puzzle\Renderer\Renderer;
use Puzzle\Renderer\VisualComponent;

$board = new Board();
$renderer = new Renderer(
    new VisualComponent()
);

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
    $input = trim(fgets(STDIN));

    if (!is_numeric($input)) {
        $renderer->showMessage("Invalid input. Please enter a number.");
        continue;
    }

    $tile = (int) $input;

    if ($tile < 1 || $tile > 15) {
        $renderer->showInvalidTile();
        continue;
    }

    if (!$board->moveTile($tile)) {
       $renderer->showInvalidMove();
        continue;
    }

    echo "\n";
}
