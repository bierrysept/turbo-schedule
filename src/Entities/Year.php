<?php

namespace Bierrysept\TurboSchedule\Entities;

class Year
{
    public function __construct(private readonly int $value)
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

    public function isLeap()
    {
        if (!($this->value % 400)) {
            return true;
        }

        if (!($this->value % 100)) {
            return false;
        }

        return !($this->value % 4);
    }
}