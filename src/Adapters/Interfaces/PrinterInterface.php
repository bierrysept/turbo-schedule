<?php

namespace Bierrysept\TurboSchedule\Adapters\Interfaces;

interface PrinterInterface
{
    public function echo(string $text): void;
}