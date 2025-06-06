<?php

namespace Bierrysept\TurboSchedule\Realization;

use Bierrysept\TurboSchedule\Adapters\Interfaces\FileProcessorInterface;

class FileProcessor implements FileProcessorInterface
{

    public function fileGetContents(string $fullPath): string
    {
        return file_get_contents($fullPath);
    }

    public function filePutContents(string $fullPath, string $contents): void
    {
        file_put_contents($fullPath, $contents);
    }
}