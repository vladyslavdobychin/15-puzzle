<?php

namespace Puzzle\Renderer;

use Puzzle\Board\Board;
use Puzzle\Board\BoardConfig;

class Renderer
{
    private VisualComponent $visualComponent;

    public function __construct(VisualComponent $visualComponent)
    {
        $this->visualComponent = $visualComponent;
    }

    public function renderBoard(Board $board): void
    {
        // TODO: Do maybe I could render some sort of a frame not to make indents?
        echo $this->visualComponent->emptySpace();
        foreach ($board->getTiles() as $row) {
            foreach ($row as $tile) {
                $display = $this->visualComponent->tile($tile);
                echo $display;
            }
            echo "|\n";
        }
        echo $this->visualComponent->emptySpace();
    }

    public function showMessage(string $message): void
    {
        echo $this->visualComponent->messageSeparator();
        echo $message . "\n";
        echo $this->visualComponent->messageSeparator();
    }

    public function showWin($numberOfMoves): void
    {
        $this->showMessage("IT'S A WIN!\nNumber of moves - {$numberOfMoves}");
    }

    public function showInvalidMove(): void
    {
        $this->showMessage("Invalid move. Tile must be adjacent to an empty space.");
    }

    public function showInvalidTile(): void
    {
        $this->showMessage(
            "Invalid tile. Choose a number between " . BoardConfig::MIN_TILE . " and " . BoardConfig::MAX_TILE
        );
    }

}
