<?php

namespace Bierrysept\TurboSchedule\Tests\Adapters\Spies;

use Bierrysept\TurboSchedule\Adapters\Interfaces\FileProcessorInterface;

class FileProcessorSpy implements FileProcessorInterface
{

    private bool $wasCalledFileGetContents = false;
    private string $askedFile = '';
    private string $fileContent = "";

    public function __construct()
    {
    }

    public function wasCalledFileGetContent(): bool
    {
        return $this->wasCalledFileGetContents;
    }

    public function fileGetContents(string $fullPath): string
    {
        $this->wasCalledFileGetContents = true;
        $this->askedFile = $fullPath;
        return $this->fileContent;
    }

    public function filePutContents(string $fullPath, string $contents): void
    {
        $this->askedFile = $fullPath;
    }

    public function getAskedFile(): string
    {
        return $this->askedFile;
    }

    public function setFile(string $fileContent): void
    {
        $this->fileContent = $fileContent;
    }
}