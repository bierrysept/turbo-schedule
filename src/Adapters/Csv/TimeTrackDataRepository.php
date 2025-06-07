<?php

namespace Bierrysept\TurboSchedule\Adapters\Csv;

use Bierrysept\TurboSchedule\Adapters\CsvToDictionaryArrayConverter;
use Bierrysept\TurboSchedule\Adapters\Interfaces\FileProcessorInterface;
use Bierrysept\TurboSchedule\UseCase\Interfaces\TimeTrackDataRepositoryInterface;

class TimeTrackDataRepository implements TimeTrackDataRepositoryInterface
{

    private FileProcessorInterface $fileProcessor;
    private string $filepath = "";
    private CsvToDictionaryArrayConverter $csvConverter;

    public function setFileProcessor(FileProcessorInterface $fileProcessor): void
    {
        $this->fileProcessor = $fileProcessor;
    }

    public function setTimeTrackFilePath(string $filePath): void
    {
        $this->filepath = $filePath;
    }

    public function setCsvConverter(CsvToDictionaryArrayConverter $csvConverter): void
    {
        $this->csvConverter = $csvConverter;
    }

    public function getAll(): array
    {
        $fileContents = $this->fileProcessor->fileGetContents($this->filepath);
        return $this->csvConverter->convert($fileContents);
    }
}