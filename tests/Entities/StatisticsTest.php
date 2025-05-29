<?php

namespace Bierrysept\TurboSchedule\Tests\Entities;

use Bierrysept\TurboSchedule\Entities\Statistics;
use Bierrysept\TurboSchedule\Entities\TimeTrack;
use DateTime;
use PHPUnit\Framework\TestCase;

class StatisticsTest extends TestCase
{
    public function testOutputEmpty()
    {
        $statistics = new Statistics();
        $expectedArray = [
            '19.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '20.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '21.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
        ];
        $actualArray = $statistics->getDaysStatistics("2025-05-19", "2025-05-21");
        $this->assertEquals($expectedArray, $actualArray);

    }
    public function testOutputAfterAdd()
    {
        $timeTrack = new TimeTrack(
            "Family & friends",
            new DateTime("2025-05-19 20:00:00"),
            "02:00:00"
        );
        $statistics = new Statistics();
        $statistics->addTrack($timeTrack);
        $expectedArray = [
            '19.05.2025' => [
                "Family & friends" => "02:00:00",
                'Procrastination' => '22:00:00',
            ],
            '20.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '21.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
        ];
        $actualArray = $statistics->getDaysStatistics("2025-05-19", "2025-05-21");
        $this->assertEquals($expectedArray, $actualArray);
    }

    public function testGetStatisticByDay()
    {
        $timeTrack = new TimeTrack(
            "Family & friends",
            new DateTime("2025-05-19 20:00:00"),
            "02:00:00"
        );
        $statistics = new Statistics();
        $statistics->addTrack($timeTrack);
        $expectedArray = [
            "Family & friends" => "02:00:00",
            'Procrastination' => '22:00:00',
        ];
        $actualArray = $statistics->getDayStatistics("2025-05-19");
        $this->assertEquals($expectedArray, $actualArray);
    }

    public function testAddSevralTimeTracks ()
    {
        $timeTrack1 = new TimeTrack(
            "Family & friends",
            new DateTime("2025-05-19 20:00:00"),
            "02:00:00"
        );
        $timeTrack2 = new TimeTrack(
            "Sport & Health",
            new DateTime("2025-05-19 08:00:00"),
            "01:00:00"
        );
        $statistics = new Statistics();
        $statistics->addTrack($timeTrack1);
        $statistics->addTrack($timeTrack2);
        $expectedArray = [
            "Family & friends" => "02:00:00",
            "Sport & Health" => "01:00:00",
            'Procrastination' => '21:00:00',
        ];
        $actualArray = $statistics->getDayStatistics("2025-05-19");
        $this->assertEquals($expectedArray, $actualArray);
    }

    public function testAddSevralSameTimeTracks()
    {
        $timeTrack1 = new TimeTrack(
            "Family & friends",
            new DateTime("2025-05-19 20:00:00"),
            "02:00:00"
        );
        $timeTrack2 = new TimeTrack(
            "Family & friends",
            new DateTime("2025-05-19 08:00:00"),
            "01:00:00"
        );
        $statistics = new Statistics();
        $statistics->addTrack($timeTrack1);
        $statistics->addTrack($timeTrack2);
        $expectedArray = [
            "Family & friends" => "03:00:00",
            'Procrastination' => '21:00:00',
        ];
        $actualArray = $statistics->getDayStatistics("2025-05-19");
        $this->assertEquals($expectedArray, $actualArray);
    }
}