<?php

namespace Bierrysept\TurboSchedule\UseCase\Interfaces;

interface WeekStatisticConsolePresenterInterface
{
    public function present(array $presentData): void;
}