<?php

namespace Bierrysept\TurboSchedule\Adapters\Console;

class WeekStatisticConsolePresenter
{

    public function __construct()
    {
    }

    public function presents(array $statistics)
    {
        $days = [];
        $activities = [];
        foreach ($statistics as $day => $dayData) {
            $days []= $day;

            foreach ($dayData as $activity => $time) {
                $activities[$activity] ??= [];
                $activities[$activity][$day] = $time;
            }
        }

        $output = "+---------------+----------+----------+----------+----------+----------+----------+----------+
|               |";
        foreach ($days as $day) {
            $output .= $day . "|";
        }
        $output .= PHP_EOL;
        foreach ($activities as $activityName => $timesByDate) {
            $output .= "+---------------+----------+----------+----------+----------+----------+----------+----------+";
            $output .= PHP_EOL;
            $output .= sprintf("|%-15s|", $activityName);
            foreach ($days as $day) {
                $time = $timesByDate[$day] ?? '--:--:--';
                $output .= " $time |";
            }
            $output .= PHP_EOL;
        }
        $output .= "+---------------+----------+----------+----------+----------+----------+----------+----------+";
        return $output;
    }
}