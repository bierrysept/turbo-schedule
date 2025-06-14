<?php

namespace Bierrysept\TurboSchedule\Tests\Entities;

use Bierrysept\TurboSchedule\Entities\Statistics;
use Bierrysept\TurboSchedule\Entities\TimeTrack\TimeTrack;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class StatisticsTest extends TestCase
{
    private Statistics $statistics;

    public function setUp(): void
    {
        $this->statistics = new Statistics();
    }

    /**
     * @throws Exception
     */
    public function testOutputEmpty(): void
    {
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
        $actualArray = $this->statistics->getDaysStatistics("2025-05-19", "2025-05-21");
        $this->assertEquals($expectedArray, $actualArray);
    }

    /**
     * @throws Exception
     */
    public function testSkipDate(): void
    {
        $expectedArray = [
            '19.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '21.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
        ];
        $this->statistics->addSkipDay("2025-05-20");
        $actualArray = $this->statistics->getDaysStatistics("2025-05-19", "2025-05-21");
        $this->assertEquals($expectedArray, $actualArray);
    }

    /**
     * @throws Exception
     */
    public function testOutputAfterAdd(): void
    {
        $timeTrack = new TimeTrack(
            "Family & friends",
            new DateTime("2025-05-19 20:00:00"),
            "02:00:00"
        );
        $this->statistics->addTrack($timeTrack);
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
        $actualArray = $this->statistics->getDaysStatistics("2025-05-19", "2025-05-21");
        $this->assertEquals($expectedArray, $actualArray);
    }

    public function testGetStatisticByDay(): void
    {
        $timeTrack = new TimeTrack(
            "Family & friends",
            new DateTime("2025-05-19 20:00:00"),
            "02:00:00"
        );
        $this->statistics->addTrack($timeTrack);
        $expectedArray = [
            "Family & friends" => "02:00:00",
            'Procrastination' => '22:00:00',
        ];
        $actualArray = $this->statistics->getDayStatistics("2025-05-19");
        $this->assertEquals($expectedArray, $actualArray);
    }

    public function testAddSeveralTimeTracks (): void
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
        $this->statistics->addTrack($timeTrack1);
        $this->statistics->addTrack($timeTrack2);
        $expectedArray = [
            "Family & friends" => "02:00:00",
            "Sport & Health" => "01:00:00",
            'Procrastination' => '21:00:00',
        ];
        $actualArray = $this->statistics->getDayStatistics("2025-05-19");
        $this->assertEquals($expectedArray, $actualArray);
    }

    public function testAddSeveralSameTimeTracks(): void
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
        $this->statistics->addTrack($timeTrack1);
        $this->statistics->addTrack($timeTrack2);
        $expectedArray = [
            "Family & friends" => "03:00:00",
            'Procrastination' => '21:00:00',
        ];
        $actualArray = $this->statistics->getDayStatistics("2025-05-19");
        $this->assertEquals($expectedArray, $actualArray);
    }

    /**
     * @throws Exception
     */
    public function testAddSeveralSameTimeTracksWithAllDaysStatistic(): void
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
        $this->statistics->addTrack($timeTrack1);
        $this->statistics->addTrack($timeTrack2);
        $expectedArray = [
            '19.05.2025' => [
                "Family & friends" => "03:00:00",
                'Procrastination' => '21:00:00',
            ]
        ];
        $actualArray = $this->statistics->getAllDaysStatistics();
        $this->assertEquals($expectedArray, $actualArray);
    }
}