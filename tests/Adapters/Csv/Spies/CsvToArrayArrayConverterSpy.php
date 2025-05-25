<?php

namespace Bierrysept\TurboSchedule\Tests\Adapters\Csv\Spies;

use Bierrysept\TurboSchedule\Adapters\CsvToArrayArrayConverter;

class CsvToArrayArrayConverterSpy extends CsvToArrayArrayConverter
{
    private const CONVERSIONS = [
        "id,type,\"task name\"\n10,support,\"bugfix latte cup\"" => [
            ['id', 'type', "task name"],
            ['10', 'support', 'bugfix latte cup']
        ],
        "id,type,\"task name\"\n10,bugfix,\"bugfix latte cup\"\n15,feature,\"Make more milkier\"" => [
            ['id', 'type', "task name"],
            ['10', 'bugfix', "bugfix latte cup"],
            ['15', 'feature', "Make more milkier"]
        ],
        "id,type,\"task name\"\n10,bugfix,\"bugfix latte cup\"\n15,feature,\"Make more milkier\"\n" => [
            ['id', 'type', "task name"],
            ['10', 'bugfix', "bugfix latte cup"],
            ['15', 'feature', "Make more milkier"],
            ['']
        ]
    ];
    private bool $wasConvert = false;

    public function wasConvert(): bool
    {
        return $this->wasConvert;
    }

    public function convert(string $input): array
    {
        $this->wasConvert = true;
        return self::CONVERSIONS[$input] ?? [[""]];
    }
}