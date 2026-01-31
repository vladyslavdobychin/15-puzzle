<?php

namespace Puzzle\Renderer;

use Puzzle\Board\Board;

class Renderer
{
    private VisualComponent $visualComponent;

    public function __construct(VisualComponent $visualComponent)
    {
        $this->visualComponent = $visualComponent;
    }

    public function renderBoard(Board $board): void
    {
        foreach ($board->getTiles() as $row) {
            foreach ($row as $tile) {
                $display = $this->visualComponent->tile($tile);
                echo $display;
            }
            echo "|\n";
        }
    }

    public function showMessage(string $message): void
    {
        echo $this->visualComponent->messageSeparator();
        echo $message . "\n";
        echo $this->visualComponent->messageSeparator();
    }

    public function showWin(): void
    {
        $this->showMessage("IT'S A WIN!");
    }

    public function showInvalidMove(): void
    {
        $this->showMessage("Invalid move. Tile must be adjacent to an empty space.");
    }

    public function showInvalidTile(): void
    {
        $this->showMessage("Invalid tile. Choose 1-15.");
    }

}
