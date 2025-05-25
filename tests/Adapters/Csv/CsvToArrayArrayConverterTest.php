<?php

namespace Bierrysept\TurboSchedule\Tests\Adapters\Csv;

use Bierrysept\TurboSchedule\Adapters\CsvToArrayArrayConverter;
use PHPUnit\Framework\TestCase;

class CsvToArrayArrayConverterTest extends TestCase
{
    private CsvToArrayArrayConverter $csvToArrayArrayConverter;

    public function setUp():void
    {
        $this->csvToArrayArrayConverter = new CsvToArrayArrayConverter();
    }
    public function testTwoEmptyRows(): void
    {
        $input = "\n";
        $converter = $this->csvToArrayArrayConverter;
        $expectedArrayArray = [[""], [""]];
        $actualArrayArray = $converter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }

    public function testTwoEmptyCells()
    {
        $input = ",";
        $converter = $this->csvToArrayArrayConverter;
        $expectedArrayArray = [["",""]];
        $actualArrayArray = $converter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }

    public function testTwoCellsThenEmptyRow()
    {
        $input = ",\n";
        $converter = $this->csvToArrayArrayConverter;
        $expectedArrayArray = [["", ""], [""]];
        $actualArrayArray = $converter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }

    public function testAloneCell()
    {
        $input = "Test";
        $expectedArrayArray = [["Test"]];
        $actualArrayArray = $this->csvToArrayArrayConverter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }

    public function testCellWithEmptyCell() // 7
    {
        $input = "Test,\n";
        $expectedArrayArray = [["Test", ""], [""]];
        $actualArrayArray = $this->csvToArrayArrayConverter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }

    public function testQuotedCell() // 8
    {
        $input = "\"Test,Test\nTest\"";
        $expectedArrayArray = [["Test,Test\nTest"]];
        $actualArrayArray = $this->csvToArrayArrayConverter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }

    public function testQutedCellAndRow() // 9
    {
        $input = "\"Test,Test\nTest\"\n";
        $expectedArrayArray = [["Test,Test\nTest"], [""]];
        $actualArrayArray = $this->csvToArrayArrayConverter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }

    public function testQutedCellAndCell() // 9
    {
        $input = "\"Test,Test\nTest\",";
        $expectedArrayArray = [["Test,Test\nTest", ""]];
        $actualArrayArray = $this->csvToArrayArrayConverter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }
}