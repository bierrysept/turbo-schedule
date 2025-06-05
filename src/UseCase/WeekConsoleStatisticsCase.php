<?php

namespace Bierrysept\TurboSchedule\UseCase;

use Bierrysept\TurboSchedule\Entities\Statistics;
use Bierrysept\TurboSchedule\Entities\TimeTrack\TimeTrackFactory;
use Bierrysept\TurboSchedule\UseCase\Interfaces\TimeTrackDataRepositoryInterface;
use Bierrysept\TurboSchedule\UseCase\Interfaces\WeekStatisticConsolePresenterInterface;
use Exception;

class WeekConsoleStatisticsCase
{

    private TimeTrackDataRepositoryInterface $timeTrackDataRepository;
    private WeekStatisticConsolePresenterInterface $weekStatisticConsolePresenterSpy;
    public function __construct()
    {
    }

    public function setTimeTrackDataRepository(TimeTrackDataRepositoryInterface $timeTrackDataRepositorySpy): void
    {
        $this->timeTrackDataRepository = $timeTrackDataRepositorySpy;
    }

    public function setWeekStatisticConsolePresenter(WeekStatisticConsolePresenterInterface $weekStatisticConsolePresenterSpy): void
    {
        $this->weekStatisticConsolePresenterSpy = $weekStatisticConsolePresenterSpy;
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $data = $this->timeTrackDataRepository->getAll();
        $converter = new TimeTrackFactory();
        $timeTracks = $converter->convert($data);
        $statistic = new Statistics();
        $statistic->addTracks($timeTracks);
        $weekStatistic = $statistic->getAllDaysStatistics();
        $this->weekStatisticConsolePresenterSpy->present($weekStatistic);
    }
}