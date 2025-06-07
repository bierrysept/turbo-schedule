<?php

namespace Bierrysept\TurboSchedule\Tests\Adapters\Console\Spies;

use Bierrysept\TurboSchedule\Adapters\Interfaces\PrinterInterface;

class PrinterSpy implements PrinterInterface
{

    private bool $wasCalledEcho = false;
    private string $echos = "";

    public function __construct()
    {
    }

    public function wasCalledEcho(): bool
    {
        return $this->wasCalledEcho;
    }

    public function echo(string $text): void
    {
        $this->wasCalledEcho = true;
        $this->echos .= $text;
    }

    public function getEchos(): string
    {
        return $this->echos;
    }
}