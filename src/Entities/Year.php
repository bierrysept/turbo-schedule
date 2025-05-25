<?php

namespace Bierrysept\TurboSchedule\Entities;

class Year
{
    public function __construct(private int $value)
    {

    }
    public function getValue(): int
    {
        return $this->value;
    }

    public function getNextYear(): Year
    {
        $oldValue = $this->value;
        $newValue = $oldValue === -1 ? 1 : $oldValue + 1;
        return new Year($newValue);
    }

    public function getPrevYear(): Year
    {
        $oldValue = $this->value;
        $newValue = $oldValue === 1 ? -1 : $oldValue - 1;
        return new Year($newValue);
    }

    public function equals(Year $year): bool
    {
        return $year->getValue() === $this->getValue();
    }
}