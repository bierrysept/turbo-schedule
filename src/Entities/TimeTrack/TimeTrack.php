<?php

namespace Bierrysept\TurboSchedule\Entities\TimeTrack;

use DateTime;

readonly class TimeTrack
{
    public function __construct(private string $activity, private DateTime $start, private string $duration)
    {
    }

    public function getDate(): string
    {
        return $this->start->format("Y-m-d");
    }

    public function getStartTime(): string
    {
        return $this->start->format("H:i:s");
    }

    public function getEndTime(): string
    {
        $end = clone $this->start;
        $exploded = explode(":", $this->duration);
        $end->modify("+$exploded[0] hours");
        $end->modify("+$exploded[1] minutes");
        $end->modify("+$exploded[2] seconds");
        return $end->format("H:i:s");
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function getActivity(): string
    {
        return $this->activity;
    }

    public function equals(TimeTrack $timeTrack): bool
    {
        if ($this->activity !== $timeTrack->activity) {
            return false;
        }

        if ($this->duration !== $timeTrack->duration) {
            return false;
        }

        if ($this->start->format("Y-m-d H:i:s") !== $timeTrack->start->format("Y-m-d H:i:s")) {
            return false;
        }
        return true;
    }
}