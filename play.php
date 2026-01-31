<?php

require_once 'vendor/autoload.php';

use Puzzle\Board\Board;

$board = new Board();

while (true) {
    foreach ($board->getTiles() as $row) {
        foreach ($row as $tile) {
            $display = $tile === null ? "  " : sprintf('%2d', $tile);
            echo "| {$display} ";
        }
        echo "|\n";
    }
    if ($board->isSolved()) {
        echo "\n IT'S A WIN!\n";
        break;
    }

    echo "\nEnter tile number to move: ";
    $input = trim(fgets(STDIN));

    if (!is_numeric($input)) {
        echo "Invalid input. Please enter a number.\n";
        continue;
    }

    $tile = (int) $input;

    if ($tile < 1 || $tile > 15) {
        echo "+------------------------+\n";
        echo "Invalid tile. Choose 1-15.\n";
        echo "+------------------------+\n";
        continue;
    }

    if (!$board->moveTile($tile)) {
        echo "+------------------------+\n";
        echo "Invalid move. Tile must be adjacent to an empty space.\n";
        echo "+------------------------+\n";
        continue;
    }

    echo "\n";
}
