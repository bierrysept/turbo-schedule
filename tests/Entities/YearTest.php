<?php

namespace Bierrysept\TurboSchedule\Tests\Entities;

use Bierrysept\TurboSchedule\Entities\Year;
use PHPUnit\Framework\TestCase;

class YearTest extends TestCase
{
    private Year $year;
    private Year $year2;

    public function setUp(): void
    {
        $this->year = new Year(2007);
        $this->year2 = new Year(2012);
    }
    public function testCreateYear(): void
    {
        $this->assertEquals(2007, $this->year->getValue());

        $this->assertEquals(2012, $this->year2->getValue());
    }

    public function testGetNextYear(): void
    {
        $this->assertEquals(2008, $this->year->getNextYear()->getValue());

        $this->assertEquals(2013, $this->year2->getNextYear()->getValue());
    }

    public function testGetPrevYear(): void
    {
        $this->assertEquals(2006, $this->year->getPrevYear()->getValue());

        $this->assertEquals(2011, $this->year2->getPrevYear()->getValue());
    }

    public function testPrevFirstYear()
    {
        $firstYear = new Year(1);
        $this->assertEquals(-1, $firstYear->getPrevYear()->getValue());
    }

    public function testFirstEraYearNext()
    {
        $firstYear = new Year(-1);
        $this->assertEquals(1, $firstYear->getNextYear()->getValue());
    }
}