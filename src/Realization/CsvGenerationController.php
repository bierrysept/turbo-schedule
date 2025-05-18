<?php
/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedNamespaceInspection
 * @noinspection UnknownInspectionInspection
 */

namespace Bierrysept\TurboSchedule\Realization;

use Bierrysept\TurboSchedule\Adapters\CsvToArrayArrayConverter;
use Bierrysept\TurboSchedule\Adapters\TestCsvDataGenerator;
use Composer\Script\Event;

/**
 * Controller for run scripts from composer
 * @used-by \Composer\EventDispatcher\EventDispatcher
 */
class CsvGenerationController
{
    /**
     * Generate test CSV data
     * @param Event $event
     * @return void
     * @used-by \Composer\EventDispatcher\EventDispatcher
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

    /**
     * Debug output
     * @used-by \Composer\EventDispatcher\EventDispatcher
     * @return void
     */
    public static function printR():void
    {
        $file = file_get_contents(dirname(__DIR__)."/temp/boosted.csv");
        $converter = new CsvToArrayArrayConverter();
        print_r($converter->convert($file));
    }
}