<?php

namespace Bierrysept\TurboSchedule\Entities;

class Month
{
    private int $number;
    private Year $year;

    /**
     * @param int $monthNumber
     * @param Year|int $year
     */
    public function __construct(int $monthNumber, Year|int $year)
    {
        $this->number = $monthNumber;
        $this->year = $year instanceof Year ? $year : new Year($year);
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getYear(): Year
    {
        if (is_int($this->year)) {
            $year = new Year($this->year);
        } else {
            $year = $this->year;
        }

        return $year;
    }

    public function equals(Month $month): bool
    {
        return $this->number === $month->number && $this->year->equals($month->year);
    }

    public function getNextMonth(): Month
    {
        if ($this->number === 12) {
            $newYear = $this->year->getNextYear();
            $newMonth = 1;
        } else {
            $newYear = $this->year;
            $newMonth = $this->number + 1;
        }
        return new Month($newMonth, $newYear);
    }

    public function getPrevMonth(): Month
    {
        if ($this->number === 1) {
            $newMonth = 12;
            $newYear = $this->year->getPrevYear();
        } else {
            $newMonth = $this->number - 1;
            $newYear = $this->year;
        }
        return new Month($newMonth, $newYear);
    }
}