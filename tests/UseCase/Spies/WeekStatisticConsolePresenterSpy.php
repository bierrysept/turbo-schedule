<?php

namespace Bierrysept\TurboSchedule\Tests\UseCase\Spies;

use Bierrysept\TurboSchedule\UseCase\Interfaces\WeekStatisticConsolePresenterInterface;

class WeekStatisticConsolePresenterSpy implements WeekStatisticConsolePresenterInterface
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

    public function present(array $presentData): void
    {
        $this->wasCalledPresent = true;
        $this->inputData = $presentData;
    }

    public function getInputData(): array
    {
        return $this->inputData;
    }
}