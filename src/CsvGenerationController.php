<?php

namespace Bierrysept\TurboSchedule;

use Composer\Script\Event;

class CsvGenerationController
{
    /**
     * @param Event $event
     * @return void
     */
    public static function generateCsv(Event $event):void
    {
        echo "Run generate:\n";
        $arguments = $event->getArguments();
        $csvCount = $arguments[0];
        echo "\$test = [\n";
        $csvGenerator = new TestCsvDataGenerator();
        $gap = 0;
        for ($i = 0; $i < $csvCount; $i++) {
            $testData = str_replace(["\n", "\""], ["\\n","\\\""], $csvGenerator->generateFile($i+$gap));
            $residue = $csvGenerator->getResidue();
            if ($residue) {
                $i--;
                $gap++;
                continue;
            }
            echo "\t$i => \"$testData\",\n";
        }
        echo "];\n";
    }
}