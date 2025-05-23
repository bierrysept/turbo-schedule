<?php

namespace Bierrysept\TurboSchedule\Adapters;

class CsvToDictionaryArrayConverter
{

    private CsvToArrayArrayConverter $converter;

    public function convert(string $input): array
    {
        $rawTable = $this->converter->convert($input);
        $header = $rawTable[0];
        unset($rawTable[0]);

        $output = [];
        foreach ($rawTable as $rawRow) {
            if ($rawRow === ['']) {
                continue;
            }
            $output []= array_combine($header, $rawRow);
        }
         return $output;
    }

    /**
     * @param CsvToArrayArrayConverter $converter
     * @return void
     */
    public function setCsvConverter(CsvToArrayArrayConverter $converter): void
    {
        $this->converter = $converter;
    }
}