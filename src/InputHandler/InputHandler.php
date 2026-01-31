<?php

namespace Puzzle\InputHandler;

use Puzzle\Board\BoardConfig;

class InputHandler
{
    public function readLine(): string
    {
        return trim(fgets(STDIN));
    }

}
