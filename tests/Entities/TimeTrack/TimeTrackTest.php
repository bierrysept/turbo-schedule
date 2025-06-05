<?php

namespace Bierrysept\TurboSchedule\Tests\Entities\TimeTrack;

use Bierrysept\TurboSchedule\Entities\TimeTrack\TimeTrack;
use DateTime;
use PHPUnit\Framework\TestCase;

class TimeTrackTest extends TestCase
{
    public function testJustCreate(): void
    {
        $timeTrack = new TimeTrack("Family & friends", new DateTime("2025-05-25 20:00:00"), "02:00:00");
        $this->assertEquals("2025-05-25", $timeTrack->getDate());
        $this->assertEquals("20:00:00", $timeTrack->getStartTime());
        $this->assertEquals("22:00:00", $timeTrack->getEndTime());
        $this->assertEquals("02:00:00", $timeTrack->getDuration());
        $this->assertEquals("Family & friends", $timeTrack->getActivity());
    }

    public function testEquals()
    {
        $timeTrack = new TimeTrack("Family & friends", new DateTime("2025-05-25 20:00:00"), "02:00:00");
        $timeTrack2 = new TimeTrack("Family & friends", new DateTime("2025-05-25 20:00:00"), "02:00:00");
        $this->assertTrue($timeTrack->equals($timeTrack2));

        $timeTrack = new TimeTrack("Family & friends", new DateTime("2025-05-25 20:00:00"), "02:00:00");
        $timeTrack2 = new TimeTrack("Family", new DateTime("2025-05-25 20:00:00"), "02:00:00");
        $this->assertFalse($timeTrack->equals($timeTrack2));

        $timeTrack = new TimeTrack("Family & friends", new DateTime("2025-05-25 20:00:00"), "02:00:00");
        $timeTrack2 = new TimeTrack("Family & friends", new DateTime("2025-05-25 21:00:00"), "02:00:00");
        $this->assertFalse($timeTrack->equals($timeTrack2));

        $timeTrack = new TimeTrack("Family & friends", new DateTime("2025-05-25 20:00:00"), "02:00:00");
        $timeTrack2 = new TimeTrack("Family & friends", new DateTime("2025-05-25 20:00:00"), "01:00:00");
        $this->assertFalse($timeTrack->equals($timeTrack2));
    }
}