<?php

namespace Puzzle\Board;

class BoardFactory {
    private BoardShuffler $shuffler;

    public function __construct(BoardShuffler $shuffler) {
        $this->shuffler = $shuffler;
    }

    /**
     * Creates a board in a solved state and then performs a provided (100 by default)
     * number of random moves. This ensures that the player gets only solvable puzzles.
     *
     * @param int $moves
     * @return Board
     */
    public function createShuffled(int $moves = 100): Board {
        $board = new Board(BoardConfig::SOLVED);
        $this->shuffler->shuffle($board, $moves);
        return $board;
    }

    /**
     * Creates a board requiring only one move to be solved. May be used for player tutorials and testing.
     *
     * @return Board
     */
    public function createOneMoveAway(): Board {
        return new Board(BoardConfig::ONE_MOVE_AWAY);
    }

    /**
     * Creates a board requiring two moves to be solved. May be used for testing of moves counter.
     *
     * @return Board
     */
    public function createTwoMovesAway(): Board {
        return new Board(BoardConfig::TWO_MOVES_AWAY);
    }

    /**
     * Creates a board in a solved state, playing this board will immediately roll the end of the game message.
     *
     * @return Board
     */
    public function createSolved(): Board
    {
        return new Board(BoardConfig::SOLVED);
    }
}