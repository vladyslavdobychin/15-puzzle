<?php

require_once 'vendor/autoload.php';

use Puzzle\Board\Board;

$board = new Board();

foreach ($board->getTiles() as $row) {
    foreach ($row as $tile) {
        $display = $tile === null ? "  " : sprintf('%2d', $tile);
        echo "| {$display} ";
    }
    echo "|\n";
}

echo "\nEnter tile number to move: ";

$tile = trim(fgets(STDIN));

echo "\n You've entered: $tile";