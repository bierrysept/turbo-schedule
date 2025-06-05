<?php

namespace Bierrysept\TurboSchedule\UseCase\Interfaces;

interface TimeTrackDataRepositoryInterface
{
    public function getAll(): array;
}