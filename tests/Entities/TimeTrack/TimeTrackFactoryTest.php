<?php

namespace Bierrysept\TurboSchedule\Tests\Entities\TimeTrack;

use Bierrysept\TurboSchedule\Entities\TimeTrack\TimeTrack;
use Bierrysept\TurboSchedule\Entities\TimeTrack\TimeTrackFactory;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class TimeTrackFactoryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testConvertEmpty(): void
    {
        $input = [];
        $expected = [];
        $converter = new TimeTrackFactory();
        $actual = $converter->convert($input);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @throws Exception
     */
    public function testConvertToOneTimeTrack(): void
    {
        $input = [
            [
                "Project name" => "Дела",
                "Task name" => "Готовка",
                "Date" => "2025-04-14",
                "Start time" => "07:42:50",
                "End time" => "07:47:13",
                "Duration" => "00:04:23",
                "Time zone" => "+03:00",
                "Project archived" => false,
                "Task completed" => false,
            ]
        ];
        $expectedTimeTrack = new TimeTrack(
            "Дела",
            new DateTime("2025-04-14 07:42:50"),
            "00:04:23"
        );
        $converter = new TimeTrackFactory();
        $actual = $converter->convert($input);
        $this->assertTrue($expectedTimeTrack->equals($actual[0]));
    }
}