<?php

namespace Bierrysept\TurboSchedule\UseCase;

use Bierrysept\TurboSchedule\Adapters\Entities\DictionaryArrayToTimeTracksConverter;
use Bierrysept\TurboSchedule\Entities\Statistics;
use Bierrysept\TurboSchedule\Tests\UseCase\Spies\TimeTrackDataRepositorySpy;
use Bierrysept\TurboSchedule\Tests\UseCase\Spies\WeekStatisticConsolePresenterSpy;
use Exception;

class WeekConsoleStatisticsCase
{

    private TimeTrackDataRepositorySpy $timeTrackDataRepository;
    private WeekStatisticConsolePresenterSpy $weekStatisticConsolePresenterSpy;
    public function __construct()
    {
    }

    public function setTimeTrackDataRepository(TimeTrackDataRepositorySpy $timeTrackDataRepositorySpy): void
    {
        $this->timeTrackDataRepository = $timeTrackDataRepositorySpy;
    }

    public function setWeekStatisticConsolePresenter(WeekStatisticConsolePresenterSpy $weekStatisticConsolePresenterSpy): void
    {
        $this->weekStatisticConsolePresenterSpy = $weekStatisticConsolePresenterSpy;
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $data = $this->timeTrackDataRepository->getAll();
        $converter = new DictionaryArrayToTimeTracksConverter();
        $timeTracks = $converter->convert($data);
        $statistic = new Statistics();
        $statistic->addTracks($timeTracks);
        $weekStatistic = $statistic->getAllDaysStatistics();
        $this->weekStatisticConsolePresenterSpy->present($weekStatistic);
    }
}