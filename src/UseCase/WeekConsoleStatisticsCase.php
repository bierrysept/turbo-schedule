<?php

namespace Bierrysept\TurboSchedule\UseCase;

use Bierrysept\TurboSchedule\Adapters\Entities\DictionaryArrayToTimeTracksConverter;
use Bierrysept\TurboSchedule\Entities\Statistics;
use Bierrysept\TurboSchedule\Tests\UseCase\Spies\WeekStatisticConsolePresenterSpy;
use Bierrysept\TurboSchedule\UseCase\Interfaces\TimeTrackDataRepositoryInterface;
use Exception;

class WeekConsoleStatisticsCase
{

    private TimeTrackDataRepositoryInterface $timeTrackDataRepository;
    private WeekStatisticConsolePresenterSpy $weekStatisticConsolePresenterSpy;
    public function __construct()
    {
    }

    public function setTimeTrackDataRepository(TimeTrackDataRepositoryInterface $timeTrackDataRepositorySpy): void
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