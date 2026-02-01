# 15 Puzzle Game

A terminal-based implementation of the classic 15 Puzzle sliding game in PHP.

## About the Game

The 15 Puzzle is a sliding puzzle consisting of a 4×4 grid with numbered tiles (1-15) and one empty space. The objective is to arrange the tiles in numerical order from left to right, top to bottom, with the empty space in the bottom-right corner.

You can only move tiles that are adjacent to the empty space. The game automatically saves your progress after every move, so you can continue where you left off when you reopen it.

## Game Commands

While playing, you can use these commands:

- **`restart`** - Start a new game
- **`exit`** - Exit the game
- **`help`** - Show available commands
- **`moves`** - Display your current move count

Or simply enter a tile number (1-15) to move it.

## Quick Start

### Running with Docker

Play the game:
```bash
docker compose run --rm puzzle
```

Run tests:
```bash
docker compose run --rm test
```

### Running with Composer

Play the game:
```bash
composer install
composer play
```

Run tests:
```bash
composer test
```

## Development

### Branch Naming Convention

Branch names should follow the pattern: `{feature-name}-{action-type}`

Examples:
- `board-setup`
- `home-screen-update`
- `commands-refactoring`

### Commit Message Convention

Commit messages should follow the pattern: `{name-of-the-branch}: {commit-message}`

Examples:
- `tests-setup: add board tests`
- `home-screen-update: add tutorial option`
- `commands-refactoring: extract input parser`

## Requirements

- **Docker**: Docker & Docker Compose (recommended)
- **Native**: PHP 8.2+ and Composer