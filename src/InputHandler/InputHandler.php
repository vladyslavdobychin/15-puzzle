<?php

namespace Puzzle\InputHandler;

class InputHandler
{
    public function getUserInput(): int
    {
        while (true) {
            $input = trim(fgets(STDIN));

            if (!is_numeric($input)) {
                echo "+------------------------+\n";
                echo "Invalid input. Please enter a number.\n";
                echo "+------------------------+\n";
                continue;
            }

            $tile = (int)$input;

            if ($tile < 1 || $tile > 15) {
                echo "+------------------------+\n";
                echo "Invalid tile. Choose 1-15.\n";
                echo "+------------------------+\n";
                continue;
            }

            return $tile;
        }
    }

}
