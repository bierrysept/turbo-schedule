<?php

namespace Bierrysept\TurboSchedule\Tests\UseCase\Spies;

use Bierrysept\TurboSchedule\UseCase\Interfaces\TimeTrackDataRepositoryInterface;

class TimeTrackDataRepositorySpy implements TimeTrackDataRepositoryInterface
{

    private bool $wasAskedAll = false;
    private array $repo = [];

    public function __construct()
    {
    }

    public function wasAskedAll(): bool
    {
        return $this->wasAskedAll;
    }

    public function getAll(): array
    {
        $this->wasAskedAll = true;
        return $this->repo;
    }

    public function setRepo(array $array): void
    {
        $this->repo = $array;
    }
}