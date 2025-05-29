<?php

namespace Bierrysept\TurboSchedule\Entities;

use DateTime;
use Exception;

class Statistics
{

    private const DEFAULT_ACTIVITY = 'Procrastination';

    private array $timeTracks = [];
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
            if (!isset($outputByDate[$activity])) {
                $outputByDate[$activity] = $duration;
            } else {
                $oldDuration = $outputByDate[$activity];
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
                $outputByDate[$activity] = sprintf(
                    "%02d:%02d:%02d",
                    $newDurationHours,
                    $newDurationMinutes,
                    $newDurationSeconds
                );
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

}