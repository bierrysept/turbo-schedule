<?php

namespace Bierrysept\TurboSchedule;

class TestCsvDataGenerator
{

    private int $residue = 0;
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

    public function getResidue(): int
    {
        return $this->residue;
    }

    public function generateLine(int $index): string
    {
        $this->residue = intdiv($index, 2);
        $lineIndex = $index % 2;
        $firstCell = $this->generateCell($this->residue);
        if ($lineIndex === 0) {
            return $firstCell;
        }
        return "$firstCell,".$this->generateLine($this->residue);
    }

    public function generateFile(int $index): string
    {
        $this->residue = intdiv($index, 2);
        $fileIndex = $index % 2;
        $firstLine = $this->generateLine($this->residue);
        if ($fileIndex === 0) {
            return $firstLine;
        }

        return $firstLine . "\n" . $this->generateFile($this->residue);
    }
}