<?php

namespace Bierrysept\TurboSchedule\Entities\TimeTrack;

use DateTime;
use Exception;

class TimeTrackFactory
{


    /**
     * @throws Exception
     */
    public function convert(array $input): array
    {
        $output = [];
        foreach ($input as $timeData) {
            $output []= new TimeTrack(
                $timeData["Project name"],
                new DateTime($timeData["Date"] . " " . $timeData["Start time"]),
                $timeData["Duration"]
            );
        }
        return $output;
    }
}