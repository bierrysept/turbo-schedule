<?php
/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedNamespaceInspection
 * @noinspection UnknownInspectionInspection
 */

namespace Bierrysept\TurboSchedule\Realization;

use Bierrysept\TurboSchedule\Adapters\Console\WeekStatisticConsolePresenter;
use Bierrysept\TurboSchedule\Adapters\Csv\TimeTrackDataRepository;
use Bierrysept\TurboSchedule\Adapters\CsvToArrayArrayConverter;
use Bierrysept\TurboSchedule\Adapters\CsvToDictionaryArrayConverter;
use Bierrysept\TurboSchedule\Adapters\TestCsvDataGenerator;
use Bierrysept\TurboSchedule\UseCase\WeekConsoleStatisticsCase;
use Composer\Script\Event;
use Exception;

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
     * @noinspection ForgottenDebugOutputInspection
     */
    public static function printR():void
    {
        $file = file_get_contents(dirname(__DIR__, 2)."/temp/boosted.csv");
        $converter = new CsvToDictionaryArrayConverter();
        $converter->setCsvConverter(new CsvToArrayArrayConverter());
        print_r($converter->convert($file));
    }

    /**
     * Main CSV Output
     * @used-by \Composer\EventDispatcher\EventDispatcher
     * @return void
     * @throws Exception
     */
    public static function outputBoosted():void
    {
        $filepath = dirname(__DIR__, 2) . "/temp/boosted.csv";

        $fileProcessor = new FileProcessor();
        $printer = new Printer();

        $csvToArrayArrayConverter = new CsvToArrayArrayConverter();

        $csvToDictionaryArrayConverter = new CsvToDictionaryArrayConverter();
        $csvToDictionaryArrayConverter->setCsvConverter($csvToArrayArrayConverter);

        $repository = new TimeTrackDataRepository();
        $repository->setCsvConverter($csvToDictionaryArrayConverter);
        $repository->setTimeTrackFilePath($filepath);
        $repository->setFileProcessor($fileProcessor);

        $presenter = new WeekStatisticConsolePresenter();
        $presenter->setPrinter($printer);

        $case = new WeekConsoleStatisticsCase();
        $case->setTimeTrackDataRepository($repository);
        $case->setWeekStatisticConsolePresenter($presenter);
        $case->run();
    }
}