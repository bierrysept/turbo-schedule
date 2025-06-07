<?php

namespace Bierrysept\TurboSchedule\Tests\Adapters\Csv;

use Bierrysept\TurboSchedule\Adapters\Csv\TimeTrackDataRepository;
use Bierrysept\TurboSchedule\Adapters\CsvToArrayArrayConverter;
use Bierrysept\TurboSchedule\Adapters\CsvToDictionaryArrayConverter;
use Bierrysept\TurboSchedule\Tests\Adapters\Spies\FileProcessorSpy;
use PHPUnit\Framework\TestCase;

class TimeTrackDataRepositoryTest extends TestCase
{
    private FileProcessorSpy $fileProcessorSpy;
    private TimeTrackDataRepository $timeTrackDataRepository;

    public function setUp(): void
    {
        $csvConvertToArrayArray = new CsvToArrayArrayConverter();
        $csvConvertToDictionaryArray = new CsvToDictionaryArrayConverter();
        $csvConvertToDictionaryArray->setCsvConverter($csvConvertToArrayArray);
        $this->fileProcessorSpy = new FileProcessorSpy();
        $this->timeTrackDataRepository = new TimeTrackDataRepository();
        $this->timeTrackDataRepository->setCsvConverter($csvConvertToDictionaryArray);
        $this->timeTrackDataRepository->setFileProcessor($this->fileProcessorSpy);
    }
    public function testEmptyFile(): void
    {
        $this->assertFalse($this->fileProcessorSpy->wasCalledFileGetContent());
        $actualTimeTracks = $this->timeTrackDataRepository->getAll();
        $this->assertTrue($this->fileProcessorSpy->wasCalledFileGetContent());
        $this->assertEquals([], $actualTimeTracks);
        $this->assertEquals("", $this->fileProcessorSpy->getAskedFile());
    }

    public function testHeaderOnlyFile(): void
    {
        $filePath = "time-tracks.csv";
        $fileContent = <<<FILE
"Project name","Task name","Date","Start time","End time","Duration","Time zone","Project archived","Task completed"
FILE;
        $this->fileProcessorSpy->setFile($fileContent);
        $this->timeTrackDataRepository->setTimeTrackFilePath($filePath);

        $this->assertFalse($this->fileProcessorSpy->wasCalledFileGetContent());
        $actualTimeTracks = $this->timeTrackDataRepository->getAll();
        $this->assertTrue($this->fileProcessorSpy->wasCalledFileGetContent());
        $this->assertEquals([], $actualTimeTracks);
        $this->assertEquals($filePath, $this->fileProcessorSpy->getAskedFile());
    }

    public function testOneRow(): void
    {
        $filePath = "time-tracks.csv";
        $fileContent = <<<FILE
"Project name","Task name","Date","Start time","End time","Duration","Time zone","Project archived","Task completed"
"Sport & wellness","Heal","2025-04-14","06:35:17","07:07:10","00:31:53","+03:00","false","false"
FILE;
        $this->fileProcessorSpy->setFile($fileContent);
        $this->timeTrackDataRepository->setTimeTrackFilePath($filePath);

        $this->assertFalse($this->fileProcessorSpy->wasCalledFileGetContent());
        $actualTimeTracks = $this->timeTrackDataRepository->getAll();
        $this->assertTrue($this->fileProcessorSpy->wasCalledFileGetContent());
        $this->assertEquals($filePath, $this->fileProcessorSpy->getAskedFile());
        $this->assertCount(1, $actualTimeTracks);
        $actualTimeTrack = $actualTimeTracks[0];
        $this->assertEquals("Sport & wellness", $actualTimeTrack["Project name"]);
        $this->assertEquals("00:31:53", $actualTimeTrack["Duration"]);
        $this->assertEquals("2025-04-14", $actualTimeTrack["Date"]);
    }
}