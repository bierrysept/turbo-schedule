<?php

namespace Bierrysept\TurboSchedule\Adapters\Console;

use Bierrysept\TurboSchedule\Adapters\Interfaces\PrinterInterface;
use Bierrysept\TurboSchedule\UseCase\Interfaces\WeekStatisticConsolePresenterInterface;
use DateTime;
use Exception;

class WeekStatisticConsolePresenter implements WeekStatisticConsolePresenterInterface
{

    public const ROW_DIVIDER = "+---------------+----------+----------+----------+----------+----------+----------+----------+";
    public const EMPTY_TIME = '--:--:--';
    public const EMPTY_DATE = "__.__.____";
    private PrinterInterface $printer;

    /**
     * @throws Exception from DateTime
     */
    public function getBaseTable(array $statistics): string
    {
        $activities = [];
        $maxDateYmd = "0000-00-00";
        foreach ($statistics as $day => $dayData) {
            $dateYmd = (new DateTime($day))->format("Y-m-d");
            $maxDateYmd = max($maxDateYmd, $dateYmd);
            foreach ($dayData as $activity => $time) {
                $activities[$activity] ??= [];
                $activities[$activity][$day] = $time;
            }
        }

        $days = $this->getDatesByWeekDays($maxDateYmd, $statistics);

        return $this->getDaysActivitiesTable($days, $activities);
    }

    /**
     * @param string $activityName 15 characters is maximum
     * @return string
     */
    private function getFirstCellOfRow(string $activityName): string
    {
        $length = mb_strlen($activityName);
        if ($length > 15) {
            $activityName = mb_substr($activityName, 0, 12) . "...";
        }
        return $this->outputWithGap15($activityName);
    }

    /**
     * @throws Exception from DateTime
     */
    public function present(array $presentData): void
    {
        $output = $this->getBaseTable($presentData);
        $this->printer->echo($output);
    }

    public function setPrinter(PrinterInterface $printerSpy): void
    {
        $this->printer = $printerSpy;
    }

    /**
     * @param string $maxDateYmd in YYYY-MM-DD format
     * @param array $statistics
     * @return string[]
     * @throws Exception from DateTime
     */
    private function getDatesByWeekDays(string $maxDateYmd, array $statistics): array
    {
        $weekdays = [];
        $currentDay = new DateTime($maxDateYmd);
        $weekBefore = (clone $currentDay)->modify("-7 days");
        do {
            $weekDay = (int) $currentDay->format('N');
            $date = $currentDay->format('d.m.Y');
            $weekdays[$weekDay] = isset($statistics[$date]) ? $date : self::EMPTY_DATE;
            $currentDay->modify('-1 day');
        } while ($weekBefore != $currentDay);

        ksort($weekdays);
        return $weekdays;
    }

    /**
     * @param array $days
     * @param array $activities
     * @return string
     */
    private function getDaysActivitiesTable(array $days, array $activities): string
    {
        $output = self::ROW_DIVIDER . PHP_EOL . $this->getFirstCellOfRow("");
        foreach ($days as $date) {
            $output .= $date . "|";
        }
        $output .= PHP_EOL;
        foreach ($activities as $activityName => $timesByDate) {
            $output .= self::ROW_DIVIDER;
            $output .= PHP_EOL;
            $output .= $this->getActivityRow($activityName, $days, $timesByDate);
            $output .= PHP_EOL;
        }
        $output .= self::ROW_DIVIDER;
        return $output;
    }

    /**
     * @param string $activityName
     * @param string[] $days
     * @param string[] $timesByDate
     * @return string
     */
    private function getActivityRow(string $activityName, array $days, array $timesByDate): string
    {
        $output = $this->getFirstCellOfRow($activityName);
        foreach ($days as $date) {
            $time = $timesByDate[$date] ?? self::EMPTY_TIME;
            $output .= " $time |";
        }
        return $output;
    }

    private function outputWithGap15(...$args): string
    {
        $params = $args ?? [];

        $callback = static function ($length) use (&$params) {
            $value = array_shift($params);
            return strlen($value) - mb_strlen($value) + $length[0];
        };

        $format = preg_replace_callback('/(?<=%|%-)\d+(?=s)/', $callback, "|%-15s|");

        return sprintf($format, ...$args);
    }
}