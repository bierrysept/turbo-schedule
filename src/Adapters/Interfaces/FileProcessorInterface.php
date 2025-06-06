<?php

namespace Bierrysept\TurboSchedule\Adapters\Interfaces;

interface FileProcessorInterface
{
    public function fileGetContents(string $fullPath): string;

    public function filePutContents(string $fullPath, string $contents): void;
}