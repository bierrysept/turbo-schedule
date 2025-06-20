<?php

namespace Bierrysept\TurboSchedule\Entities;

use Bierrysept\TurboSchedule\Entities\TimeTrack\TimeTrack;
use DateTime;
use Exception;

class Statistics
{

    private const DEFAULT_ACTIVITY = 'Procrastination';

    private array $timeTracks = [];

    private array $skipDays = [];

    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public function getDaysStatistics(string $from, string $to): array
    {
        $fromDateTime = new DateTime($from);
        $toDateTime = new DateTime($to);

        $output = [];
        while ($fromDateTime <= $toDateTime) {
            $date = $fromDateTime->format("d.m.Y");
            $dateYmd = $fromDateTime->format("Y-m-d");
            if (in_array($dateYmd, $this->skipDays, true)) {
                $fromDateTime->modify("+1 day");
                continue;
            }
            $outputByDate = $this->getDayStatistics($dateYmd);
            $output[$date] = $outputByDate;
            $fromDateTime->modify("+1 day");
        }

        return $output;
    }

    public function addTrack(TimeTrack $timeTrack): void
    {
        $date = $timeTrack->getDate();
        $this->timeTracks[$date] ??= [];
        $this->timeTracks[$date][]= $timeTrack;
    }


    public function getDayStatistics(string $dateYmd): array
    {
        $defaultTime = "24:00:00";
        $outputByDate = [];
        /** @var TimeTrack $timeTrack */
        foreach ($this->timeTracks[$dateYmd] ?? [] as $timeTrack) {
            $activity = $timeTrack->getActivity();
            $duration = $timeTrack->getDuration();
            if (isset($outputByDate[$activity])) {
                $outputByDate[$activity] = $this->addDurationByActivity($outputByDate[$activity], $duration);
            } else {
                $outputByDate[$activity] = $duration;
            }
            $defaultTime = $this->subDurationFromDefaultTime($defaultTime, $duration);
        }
        $outputByDate[self::DEFAULT_ACTIVITY] = $defaultTime;
        return $outputByDate;
    }

    /**
     * @param string $defaultTime
     * @param string $duration
     * @return string
     */
    private function subDurationFromDefaultTime(string $defaultTime, string $duration): string
    {
        [$defaultTimeHours, $defaultTimeMinutes, $defaultTimeSeconds] = explode(':', $defaultTime);
        [$durationHours, $durationMinutes, $durationSeconds] = explode(':', $duration);
        $defaultTimeHours -= $durationHours;
        $defaultTimeMinutes -= $durationMinutes;
        $defaultTimeSeconds -= $durationSeconds;
        if ($defaultTimeSeconds < 0) {
            $defaultTimeSeconds += 60;
            $defaultTimeMinutes--;
        }
        if ($defaultTimeMinutes < 0) {
            $defaultTimeMinutes += 60;
            $defaultTimeHours--;
        }
        return sprintf("%02d:%02d:%02d", $defaultTimeHours, $defaultTimeMinutes, $defaultTimeSeconds);
    }

    public function addTracks(array $timeTracks): void
    {
        foreach ($timeTracks as $timeTrack) {
            $this->addTrack($timeTrack);
        }
    }

    /**
     * @throws Exception
     */
    public function getAllDaysStatistics(): array
    {
        $output = [];
        foreach ($this->timeTracks as $dateYmd => $timeTracks) {
            $date = (new DateTime($dateYmd))->format("d.m.Y");
            if (in_array($dateYmd, $this->skipDays, true)) {
                continue;
            }
            $output[$date] = $this->getDayStatistics($dateYmd);
        }
        return $output;
    }

    /**
     * @param string $oldDuration
     * @param string $duration
     * @return string
     */
    private function addDurationByActivity(string $oldDuration, string $duration): string
    {
        [$oldDurationHours, $oldDurationMinutes, $oldDurationSeconds] = explode(":", $oldDuration);
        [$durationHours, $durationMinutes, $durationSeconds] = explode(':', $duration);
        $newDurationHours = (int) $oldDurationHours + (int) $durationHours;
        $newDurationMinutes = (int) $oldDurationMinutes + (int) $durationMinutes;
        $newDurationSeconds = (int) $oldDurationSeconds + (int) $durationSeconds;
        if ($newDurationSeconds > 59) {
            $newDurationSeconds -= 60;
            $newDurationMinutes++;
        }
        if ($newDurationMinutes > 59) {
            $newDurationMinutes -= 60;
            $newDurationHours++;
        }
        return sprintf(
            "%02d:%02d:%02d",
            $newDurationHours,
            $newDurationMinutes,
            $newDurationSeconds
        );
    }

    public function addSkipDay(string $string)
    {
        $this->skipDays []= $string;
    }
}