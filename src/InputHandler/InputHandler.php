<?php

namespace Puzzle\InputHandler;

use Puzzle\Board\BoardConfig;

class InputHandler
{
    public function getUserInput(): int
    {
        while (true) {
            $input = trim(fgets(STDIN));

            /*
             * TODO: I'm rendering in two places, in renderer and here, but here I can't use logic for convenient displaying of components
             */
            if (!is_numeric($input)) {
                echo "+------------------------+\n";
                echo "Invalid input. Please enter a number.\n";
                echo "+------------------------+\n";
                continue;
            }

            $tile = (int)$input;

            if ($tile < 1 || $tile > 15) {
                echo "+------------------------+\n";
                echo "Invalid tile. Choose a number between " . BoardConfig::MIN_TILE . " and " . BoardConfig::MAX_TILE . "\n";
                echo "+------------------------+\n";
                continue;
            }

            return $tile;
        }
    }

}
