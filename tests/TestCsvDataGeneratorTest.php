<?php

namespace Bierrysept\TurboSchedule\Tests;

use Bierrysept\TurboSchedule\TestCsvDataGenerator;
use PHPUnit\Framework\TestCase;

class TestCsvDataGeneratorTest extends TestCase
{
    private TestCsvDataGenerator $testCsvDataGenerator;

    public function setUp(): void
    {
        $this->testCsvDataGenerator = new TestCsvDataGenerator();
    }

    public function testOneZeroCellGenerator(): void
    {
        $testCsvData = $this->testCsvDataGenerator->generateCell(0);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals("", $testCsvData);
        $this->assertEquals(0, $residue);
    }

    public function testOneCellGeneration(): void
    {
        $testCsvData = $this->testCsvDataGenerator->generateCell(1);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals("a", $testCsvData);
        $this->assertEquals(0, $residue);
    }

    public function testOneCellWithQuoteGeneration(): void
    {
        $testCsvData = $this->testCsvDataGenerator->generateCell(2);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals("\"a\"", $testCsvData);
        $this->assertEquals(0, $residue);
    }

    public function testOneEmptyCellWithGetResidue(): void
    {
        $testCsvData = $this->testCsvDataGenerator->generateCell(3);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals("", $testCsvData);
        $this->assertEquals(1, $residue);
    }

    public function testOneZeroLine(): void
    {
        $testCsvData = $this->testCsvDataGenerator->generateLine(0);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals("", $testCsvData);
        $this->assertEquals(0, $residue);
    }

    public function testOneFirstLine()
    {
        $testCsvData = $this->testCsvDataGenerator->generateLine(1);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals(",", $testCsvData);
        $this->assertEquals(0, $residue);
    }

    public function testOneSecondLine()
    {
        $testCsvData = $this->testCsvDataGenerator->generateLine(2);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals("a", $testCsvData);
        $this->assertEquals(0, $residue);
    }

    public function testOneThirdLine()
    {
        $testCsvData = $this->testCsvDataGenerator->generateLine(3);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals("a,", $testCsvData);
        $this->assertEquals(0, $residue);
    }
    public function testOneFourthLine()
    {
        $testCsvData = $this->testCsvDataGenerator->generateLine(4);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals("\"a\"", $testCsvData);
        $this->assertEquals(0, $residue);
    }

    public function testOneFivethLine()
    {
        $testCsvData = $this->testCsvDataGenerator->generateLine(5);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals("\"a\",", $testCsvData);
        $this->assertEquals(0, $residue);
    }
    public function testCellAndQuotedCellLine()
    {
        $testCsvData = $this->testCsvDataGenerator->generateLine(27);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals("a,\"a\"", $testCsvData);
        $this->assertEquals(0, $residue);
    }

    public function testGenerateZeroFile()
    {
        $testCsvData = $this->testCsvDataGenerator->generateFile(0);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals("", $testCsvData);
        $this->assertEquals(0, $residue);
    }

    public function testGenerateOneFile()
    {
        $testCsvData = $this->testCsvDataGenerator->generateFile(1);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals("\n", $testCsvData);
        $this->assertEquals(0, $residue);
    }

    public function testGenerateCommaFile()
    {
        $testCsvData = $this->testCsvDataGenerator->generateFile(2);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals(",", $testCsvData);
        $this->assertEquals(0, $residue);
    }

    public function testGenerateBigFile()
    {
        $testCsvData = $this->testCsvDataGenerator->generateFile(178831);
        $residue = $this->testCsvDataGenerator->getResidue();
        $this->assertEquals("a,\"a\"\n\"a\",a\n\"a\",a", $testCsvData);
        $this->assertEquals(0, $residue);
    }
}