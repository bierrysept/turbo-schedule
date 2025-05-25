<?php

namespace Bierrysept\TurboSchedule\Entities;

class Day
{
    private int $day;
    private Month $month;

    /**
     * @param int $day
     * @param int|Month $month
     * @param Year|int|null $year
     */
    public function __construct(int $day, int|Month $month, null|Year|int $year = null)
    {
        if (is_int($year)) {
            $year = new Year($year);
        }

        if (is_int($month)) {
            $month = new Month($month, $year);
        }

        $this->day = $day;
        $this->month = $month;
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function getMonth(): Month
    {
        return $this->month;
    }

    public function getYear(): Year
    {
        return $this->month->getYear();
    }

    public function equals(Day $day2): bool
    {
        return $this->day === $day2->day && $this->month->equals($day2->month);
    }

    public function getNextDay(): Day
    {
        if ($this->day === $this->month->getMaxDay()) {
            $newDay = 1;
            $newMonth = $this->month->getNextMonth();
        } else {
            $newDay = $this->day + 1;
            $newMonth = $this->month;
        }
        return new Day($newDay, $newMonth);
    }

    public function getPrevDay(): Day
    {
        if ($this->day === 1) {
            $newMonth = $this->month->getPrevMonth();
            $newDay = $newMonth->getMaxDay();
        } else {
            $newDay = $this->day - 1;
            $newMonth = $this->month;
        }
        return new Day($newDay, $newMonth);
    }
}