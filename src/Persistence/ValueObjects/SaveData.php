<?php

namespace Puzzle\Persistence\ValueObjects;

readonly class SaveData
{
    public function __construct(
        public array $tiles,
        public int $moveCount,
        public string $savedAt
    ) {}

    public function toArray(): array
    {
        return [
            'tiles' => $this->tiles,
            'moveCount' => $this->moveCount,
            'savedAt' => $this->savedAt,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tiles: $data['tiles'],
            moveCount: $data['moveCount'],
            savedAt: $data['savedAt']
        );
    }
}
