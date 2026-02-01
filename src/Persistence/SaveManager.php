<?php

namespace Puzzle\Persistence;

use Puzzle\Board\Board;
use Puzzle\Board\TilesValidator;
use Puzzle\Persistence\ValueObjects\SaveData;

class SaveManager
{
    private const SAVE_DIR = 'saves';
    private const SAVE_FILE = 'current_game.json';

    private string $savePath;

    public function __construct()
    {
        $this->savePath = self::SAVE_DIR . DIRECTORY_SEPARATOR . self::SAVE_FILE;
        $this->ensureSaveDirectoryExists();
    }

    /**
     * @param Board $board
     * @param int $moveCount
     * @return void
     */
    public function save(Board $board, int $moveCount): void
    {
        $saveData = new SaveData(
            tiles: $board->getTiles(),
            moveCount: $moveCount,
            savedAt: date('Y-m-d H:i:s')
        );

        $json = json_encode($saveData->toArray(), JSON_PRETTY_PRINT);

        if ($json === false) {
            throw new \RuntimeException('Failed to encode save data to JSON');
        }

        if (file_put_contents($this->savePath, $json) === false) {
            throw new \RuntimeException('Failed to write save file');
        }
    }

    /**
     * @return SaveData|null Returns null if no valid save exists
     */
    public function load(): ?SaveData
    {
        if (!$this->exists()) {
            return null;
        }

        $json = file_get_contents($this->savePath);

        if ($json === false) {
            return null;
        }

        $data = json_decode($json, true);

        if (!$this->isValidSaveData($data)) {
            return null;
        }

        try {
            return SaveData::fromArray($data);
        } catch (\Throwable $e) {
            // Invalid save data structure
            return null;
        }
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return file_exists($this->savePath);
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        if ($this->exists()) {
            unlink($this->savePath);
        }
    }

    /**
     * @param mixed $data
     * @return bool
     */
    private function isValidSaveData(mixed $data): bool
    {
        if (!is_array($data)) {
            return false;
        }

        if (!isset($data['tiles'], $data['moveCount'], $data['savedAt'])) {
            return false;
        }

        if (!is_int($data['moveCount']) || $data['moveCount'] < 0) {
            return false;
        }

        try {
            TilesValidator::validate($data['tiles']);
        } catch (\InvalidArgumentException $e) {
            return false;
        }

        return true;
    }

    /**
     * @return void
     */
    private function ensureSaveDirectoryExists(): void
    {
        if (!is_dir(self::SAVE_DIR)) {
            mkdir(self::SAVE_DIR, 0755, true);
        }
    }
}
