<?php

namespace Bierrysept\TurboSchedule\Realization;

use Bierrysept\TurboSchedule\Adapters\Interfaces\PrinterInterface;

class Printer implements PrinterInterface
{
    public function echo(string $text): void
    {
        echo $text;
    }
}