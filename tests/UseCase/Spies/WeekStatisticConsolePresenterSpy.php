<?php

namespace Bierrysept\TurboSchedule\Tests\UseCase\Spies;

class WeekStatisticConsolePresenterSpy
{

    private bool $wasCalledPresent = false;
    private array $inputData;

    public function __construct()
    {
    }

    public function wasCalledPresent(): bool
    {
        return $this->wasCalledPresent;
    }

    public function present(array $array): void
    {
        $this->wasCalledPresent = true;
        $this->inputData = $array;
    }

    public function getInputData(): array
    {
        return $this->inputData;
    }
}