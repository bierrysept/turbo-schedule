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

    public function testTwoEmptyCells(): void
    {
        $input = ",";
        $converter = $this->csvToArrayArrayConverter;
        $expectedArrayArray = [["",""]];
        $actualArrayArray = $converter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }

    public function testTwoCellsThenEmptyRow(): void
    {
        $input = ",\n";
        $converter = $this->csvToArrayArrayConverter;
        $expectedArrayArray = [["", ""], [""]];
        $actualArrayArray = $converter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }

    public function testAloneCell(): void
    {
        $input = "Test";
        $expectedArrayArray = [["Test"]];
        $actualArrayArray = $this->csvToArrayArrayConverter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }

    public function testCellWithEmptyCell(): void
    {
        $input = "Test,\n";
        $expectedArrayArray = [["Test", ""], [""]];
        $actualArrayArray = $this->csvToArrayArrayConverter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }

    public function testQuotedCell(): void
    {
        $input = "\"Test,Test\nTest\"";
        $expectedArrayArray = [["Test,Test\nTest"]];
        $actualArrayArray = $this->csvToArrayArrayConverter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }

    public function testQuotedCellAndRow(): void
    {
        $input = "\"Test,Test\nTest\"\n";
        $expectedArrayArray = [["Test,Test\nTest"], [""]];
        $actualArrayArray = $this->csvToArrayArrayConverter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }

    public function testQuotedCellAndCell(): void
    {
        $input = "\"Test,Test\nTest\",";
        $expectedArrayArray = [["Test,Test\nTest", ""]];
        $actualArrayArray = $this->csvToArrayArrayConverter->convert($input);
        $this->assertEquals($expectedArrayArray, $actualArrayArray);
    }
}