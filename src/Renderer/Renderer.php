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
        // TODO: maybe I could render some sort of a frame not to make indents?
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

    public function showInvalidInput(): void
    {
        $this->showMessage(
            "Invalid input. Input must be a valid number between " . BoardConfig::MIN_TILE . " and " . BoardConfig::MAX_TILE . " or a valid command."
        );
    }

    public function showGoodbye(): void
    {
        $this->showMessage("Thanks for playing! Goodbye!");
    }

    public function showHelp(): void
    {
        $message = "Available commands:\n\n" .
            "  restart - Start a new game\n" .
            "  exit - Exit the game\n" .
            "  help - Show this help message\n" .
            "  moves - Show current move count\n\n" .
            "Or enter a tile number " . BoardConfig::MIN_TILE . " and " . BoardConfig::MAX_TILE . " to move it.";

        $this->showMessage($message);
    }

    public function showMoveCount(int $moveCount): void
    {
        $plural = $moveCount === 1 ? 'move' : 'moves';
        $this->showMessage("Current move count: {$moveCount} {$plural}");
    }

}
