<?php

namespace Bierrysept\TurboSchedule\Tests\Entities;

use Bierrysept\TurboSchedule\Entities\Month;
use Bierrysept\TurboSchedule\Entities\Year;
use PHPUnit\Framework\TestCase;

class MonthTest extends TestCase
{
    public function testJustCreate(): void
    {
        $month = new Month(7, 2023);
        $this->assertEquals(7, $month->getNumber());
        $this->assertEquals(2023, $month->getYear()->getValue());

        $year = new Year(2017);
        $month = new Month(9, $year);
        $this->assertEquals(9, $month->getNumber());
        $this->assertEquals($year, $month->getYear());
    }

    public function testEquals(): void
    {
        $this->assertTrue((new Month(2, 2020))->equals(new Month(2, 2020)));
        $this->assertFalse((new Month(2, 2021))->equals(new Month(2, 2020)));
    }

    public function testNextMonth(): void
    {
        $month = new Month(2, 2020);
        $nextMonth = new Month(3, 2020);
        $this->assertTrue($month->getNextMonth()->equals($nextMonth));
    }

    public function testBorderlineNextMonth(): void
    {
        $month = new Month(12, 2020);
        $nextMonth = new Month(1, 2021);
        $actualNextMonth = $month->getNextMonth();
        $this->assertEquals(2021, $actualNextMonth->getYear()->getValue());
        $this->assertEquals(1, $actualNextMonth->getNumber());
        $this->assertTrue($actualNextMonth->equals($nextMonth));
    }

    public function testPrevMonth(): void
    {
        $month = new Month(3, 2020);
        $prevMonth = new Month(2, 2020);
        $this->assertTrue($month->getPrevMonth()->equals($prevMonth));
    }

    public function testBorderlinePrevMonth(): void
    {
        $month = new Month(1, 2021);
        $prevMonth = new Month(12, 2020);
        $actualPrevMonth = $month->getPrevMonth();
        $this->assertEquals(2020, $actualPrevMonth->getYear()->getValue());
        $this->assertEquals(12, $actualPrevMonth->getNumber());
        $this->assertTrue($actualPrevMonth->equals($prevMonth));
    }

    public function testMaxDay()
    {
        $this->assertEquals(31, (new Month(1, 2020))->getMaxDay());
        $this->assertEquals(31, (new Month(3, 2020))->getMaxDay());
        $this->assertEquals(31, (new Month(5, 2020))->getMaxDay());
        $this->assertEquals(31, (new Month(7, 2020))->getMaxDay());
        $this->assertEquals(31, (new Month(8, 2020))->getMaxDay());
        $this->assertEquals(31, (new Month(10, 2020))->getMaxDay());

        $this->assertEquals(30, (new Month(4, 2020))->getMaxDay());
        $this->assertEquals(30, (new Month(6, 2020))->getMaxDay());
        $this->assertEquals(30, (new Month(9, 2020))->getMaxDay());
        $this->assertEquals(30, (new Month(11, 2020))->getMaxDay());

        $this->assertEquals(29, (new Month(2, 2020))->getMaxDay());
        $this->assertEquals(28, (new Month(2, 2021))->getMaxDay());
    }
}