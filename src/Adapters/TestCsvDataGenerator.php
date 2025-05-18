<?php

namespace Bierrysept\TurboSchedule\Adapters;

class TestCsvDataGenerator
{

    private int $residue = 0;

    /**
     * Generate Cell dummy
     * @param int $index
     * @return string
     */
    public function generateCell(int $index): string
    {
        $this->residue = intdiv($index, 3);
        $cellIndex = $index % 3;
        if ($cellIndex === 1) {
            return "a";
        }

        if ($cellIndex === 2) {
            return "\"a\"";
        }

        return "";
    }

    /**
     * Get residue from dividing
     * @return int
     */
    public function getResidue(): int
    {
        return $this->residue;
    }

    /**
     * Generate line dummy
     * @param int $index
     * @return string
     */
    public function generateRow(int $index): string
    {
        $this->residue = intdiv($index, 2);
        $lineIndex = $index % 2;
        $firstCell = $this->generateCell($this->residue);
        if ($lineIndex === 0) {
            return $firstCell;
        }
        return "$firstCell,".$this->generateRow($this->residue);
    }

    /**
     * Generate csv file dummy
     * @param int $index
     * @return string
     */
    public function generateFile(int $index): string
    {
        $this->residue = intdiv($index, 2);
        $fileIndex = $index % 2;
        $firstLine = $this->generateRow($this->residue);
        if ($fileIndex === 0) {
            return $firstLine;
        }

        return $firstLine . "\n" . $this->generateFile($this->residue);
    }
}