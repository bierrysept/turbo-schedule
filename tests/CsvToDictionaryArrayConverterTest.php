<?php

namespace Bierrysept\TurboSchedule\Tests;

use Bierrysept\TurboSchedule\Adapters\CsvToArrayArrayConverter;
use Bierrysept\TurboSchedule\Adapters\CsvToDictionaryArrayConverter;
use Bierrysept\TurboSchedule\Tests\Spies\CsvToArrayArrayConverterSpy;
use PHPUnit\Framework\TestCase;

class CsvToDictionaryArrayConverterTest extends TestCase
{
    private CsvToDictionaryArrayConverter $converter;
    private CsvToArrayArrayConverter $converterSpy;

    public function setUp(): void
    {
        $this->converter = new CsvToDictionaryArrayConverter();
        $this->converterSpy = new CsvToArrayArrayConverterSpy();
        $this->converter->setCsvConverter($this->converterSpy);
    }

    public function testConvertEmptyString(): void
    {
        $input = "";
        $expected = [];
        $this->runRegularTest($input, $expected);
    }

    public function testConvertOnlyHeader(): void
    {
        $input = "id, type, \"task name\"";
        $expected = [];
        $this->runRegularTest($input, $expected);
    }

    public function testConvertHeaderAndRow(): void
    {
        $input = "id,type,\"task name\"\n10,support,\"bugfix latte cup\"";
        $expected = [
            [
                'id' => '10',
                'type' => 'support',
                "task name" => "bugfix latte cup",
            ]
        ];
        $this->runRegularTest($input, $expected);
    }

    public function testConvertHeaderAndTwoRows(): void
    {
        $input = "id,type,\"task name\"\n10,bugfix,\"bugfix latte cup\"\n15,feature,\"Make more milkier\"";
        $expected = [
            [
                'id' => '10',
                'type' => 'bugfix',
                "task name" => "bugfix latte cup",
            ],
            [
                'id' => '15',
                'type' => 'feature',
                "task name" => "Make more milkier",
            ]
        ];
        $this->runRegularTest($input, $expected);
    }

    /**
     * @param string $input
     * @param array $expected
     * @return void
     */
    private function runRegularTest(string $input, array $expected): void
    {
        $this->assertFalse($this->converterSpy->wasConvert());
        $actual = $this->converter->convert($input);
        $this->assertTrue($this->converterSpy->wasConvert());
        $this->assertEquals($expected, $actual);
    }
}