<?php

namespace Puzzle\Input;

use Puzzle\Board\BoardConfig;

class InputHandler
{
    public function readLine(): string
    {
        return trim(fgets(STDIN));
    }

}
