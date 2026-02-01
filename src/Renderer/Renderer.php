<?php

namespace Puzzle\Renderer;

use Puzzle\Board\Board;
use Puzzle\Board\BoardConfig;

class Renderer
{
    private VisualComponent $visualComponent;

    /**
     * Enables rendering of visual elements (tiles, borders) or messages. If the message could be considered
     * an event that may happen in different contexts (Win message, Invalid input message), it is better to add
     * a separate method to display this message (e.g. showInvalidInput())
     *
     * @param VisualComponent $visualComponent
     */
    public function __construct(VisualComponent $visualComponent)
    {
        $this->visualComponent = $visualComponent;
    }

    public function renderBoard(Board $board): void
    {
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
            "Or enter a tile number between " . BoardConfig::MIN_TILE . " and " . BoardConfig::MAX_TILE . " to move it.";

        $this->showMessage($message);
    }

    public function showMoveCount(int $moveCount): void
    {
        $plural = $moveCount === 1 ? 'move' : 'moves';
        $this->showMessage("Current move count: {$moveCount} {$plural}");
    }

    public function showHomeMenu(bool $hasSave): void
    {
        echo "\n";
        echo "╔════════════════════════════╗\n";
        echo "║       15 PUZZLE GAME       ║\n";
        echo "╚════════════════════════════╝\n";
        echo "\n";
        echo "1. New Game\n";
        echo $hasSave ? "2. Continue Game\n" : "2. Continue Game (no save available)\n";
        echo "3. Tutorial\n";
        echo "4. Exit\n";
        echo "\n";
        echo "Enter your choice: ";
    }

}
