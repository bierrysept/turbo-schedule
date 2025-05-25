<?php

namespace Bierrysept\TurboSchedule\Tests\Entities;

use Bierrysept\TurboSchedule\Entities\Day;
use Bierrysept\TurboSchedule\Entities\Month;
use Bierrysept\TurboSchedule\Entities\Year;
use PHPUnit\Framework\TestCase;

class DayTest extends TestCase
{
    public function testJustCreate(): void
    {
        $day = new Day(10, 7, 2023);
        $this->assertEquals(10, $day->getDay());
        $this->assertEquals(7, $day->getMonth()->getNumber());
        $this->assertEquals(2023, $day->getYear()->getValue());

        $year = new Year(2017);
        $month = new Month(9, $year);
        $day = new Day(10, $month);
        $this->assertEquals(10, $day->getDay());
        $this->assertEquals($month, $day->getMonth());
        $this->assertEquals($year, $day->getYear());
    }

    public function testEquals(): void
    {
        $this->assertTrue((new Day(4, 2, 2020))->equals(new Day(4, 2, 2020)));
        $this->assertFalse((new Day(6,2, 2021))->equals(new Day(5,2, 2021)));
    }

    public function testNextDay(): void
    {
        $day = new Day(1, 2, 2020);
        $nextDay = new Day(2, 2, 2020);
        $this->assertTrue($day->getNextDay()->equals($nextDay));
    }

    public function testBorderlineNextDay(): void
    {
        $day = new Day(31,12, 2020);
        $nextDay = new Day(1, 1, 2021);
        $actualNextDay = $day->getNextDay();
        $this->assertEquals(2021, $actualNextDay->getYear()->getValue());
        $this->assertEquals(1, $actualNextDay->getMonth()->getNumber());
        $this->assertEquals(1, $actualNextDay->getDay());
        $this->assertTrue($actualNextDay->equals($nextDay));
    }

    public function testPrevDay(): void
    {
        $day = new Day(2, 3, 2020);
        $prevDay = new Day(1,3, 2020);
        $this->assertTrue($day->getPrevDay()->equals($prevDay));
    }

    public function testBorderlinePrevDay(): void
    {
        $day = new Day(1, 3, 2021);
        $prevDay = new Day(28, 2, 2021);
        $actualPrevDay = $day->getPrevDay();
        $this->assertEquals(2021, $actualPrevDay->getYear()->getValue());
        $this->assertEquals(2, $actualPrevDay->getMonth()->getNumber());
        $this->assertEquals(28, $actualPrevDay->getDay());
        $this->assertTrue($actualPrevDay->equals($prevDay));
    }
}