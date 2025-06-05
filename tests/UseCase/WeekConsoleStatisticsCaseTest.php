<?php

namespace Bierrysept\TurboSchedule\Tests\UseCase;

use Bierrysept\TurboSchedule\Tests\UseCase\Spies\TimeTrackDataRepositorySpy;
use Bierrysept\TurboSchedule\Tests\UseCase\Spies\WeekStatisticConsolePresenterSpy;
use Bierrysept\TurboSchedule\UseCase\WeekConsoleStatisticsCase;
use Exception;
use PHPUnit\Framework\TestCase;

class WeekConsoleStatisticsCaseTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testRunOnEmpty(): void
    {
        $weekConsoleStatisticsCase = new WeekConsoleStatisticsCase();
        $timeTrackDataRepositorySpy = new TimeTrackDataRepositorySpy();
        $weekConsoleStatisticsCase->setTimeTrackDataRepository($timeTrackDataRepositorySpy);
        $weekStatisticConsolePresenterSpy = new WeekStatisticConsolePresenterSpy();
        $weekConsoleStatisticsCase->setWeekStatisticConsolePresenter($weekStatisticConsolePresenterSpy);

        $this->assertFalse($timeTrackDataRepositorySpy->wasAskedAll());
        $this->assertFalse($weekStatisticConsolePresenterSpy->wasCalledPresent());
        $weekConsoleStatisticsCase->run();
        $this->assertTrue($timeTrackDataRepositorySpy->wasAskedAll());
        $this->assertTrue($weekStatisticConsolePresenterSpy->wasCalledPresent());
        $this->assertEquals([], $weekStatisticConsolePresenterSpy->getInputData());
    }

    /**
     * @throws Exception
     */
    public function testRunOnOneTrack(): void
    {
        $weekConsoleStatisticsCase = new WeekConsoleStatisticsCase();
        $timeTrackDataRepositorySpy = new TimeTrackDataRepositorySpy();
        $timeTrackDataRepositorySpy->setRepo(
            [
                [
                    "Project name" => "Care",
                    "Task name" => "Breakfast",
                    "Date" => "2025-04-19",
                    "Start time" => "09:18:14",
                    "End time" => "09:28:38",
                    "Duration" => "00:10:24",
                    "Time zone" => "+03:00",
                    "Project archived" => "false",
                    "Task completed" => "false"
                ]
            ]
        );
        $weekConsoleStatisticsCase->setTimeTrackDataRepository($timeTrackDataRepositorySpy);
        $weekStatisticConsolePresenterSpy = new WeekStatisticConsolePresenterSpy();
        $weekConsoleStatisticsCase->setWeekStatisticConsolePresenter($weekStatisticConsolePresenterSpy);

        $this->assertFalse($timeTrackDataRepositorySpy->wasAskedAll());
        $this->assertFalse($weekStatisticConsolePresenterSpy->wasCalledPresent());
        $weekConsoleStatisticsCase->run();
        $this->assertTrue($timeTrackDataRepositorySpy->wasAskedAll());
        $this->assertTrue($weekStatisticConsolePresenterSpy->wasCalledPresent());
        $this->assertEquals(
            [
                "19.04.2025" => [
                    "Care" => "00:10:24",
                    "Procrastination" => "23:49:36",
                ]
            ],
            $weekStatisticConsolePresenterSpy->getInputData()
        );
    }

}