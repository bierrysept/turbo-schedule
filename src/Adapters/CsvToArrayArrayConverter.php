<?php

namespace Bierrysept\TurboSchedule\Adapters;

class CsvToArrayArrayConverter
{
    private bool $wasQuote = false;
    private string $currentCell = "";
    private array $currentRow = [];
    private array $outputTable = [];
    private string $inputCurrentChar = "";

    /**
     * Convert csv-string to table
     * @param string $input
     * @return array[] [
     *  ["column 1", "column 2", "column 3"], ["cell 11", "cell 12", "cell 13"], ["cell 21", "cell 22", "cell 23"]
     * ]
     */
    public function convert(string $input): array
    {
        $inputLength = mb_strlen($input);
        $this->currentCell = "";
        $this->currentRow = [];
        $this->outputTable = [];
        for ($i = 0; $i < $inputLength; $i++) {
            $this->processChar($input, $i);
        }
        $this->currentRow []= $this->currentCell;
        $this->outputTable []= $this->currentRow;
        return $this->outputTable;
    }

    /**
     * Process csv string character
     * @param string $input
     * @param int $i
     * @return void
     */
    private function processChar(string $input, int $i): void
    {
        $this->inputCurrentChar = mb_substr($input, $i, 1);
        if ($this->symbolIsQuot()) {
            $this->wasQuote = !$this->wasQuote;
            return;
        }
        if ($this->symbolIsCellDivider()) {
            $this->currentRow []= $this->currentCell;
            $this->currentCell = "";
            return;
        }

        if ($this->symbolIsNotRowDivider()) {
            $this->currentCell .= $this->inputCurrentChar;
            return;
        }

        $this->currentRow []= $this->currentCell;
        $this->currentCell = "";
        $this->outputTable []= $this->currentRow;
        $this->currentRow = [];
    }

    /**
     * Returns true, when got comma (,) out of quotes context
     * @return bool
     */
    private function symbolIsCellDivider(): bool
    {
        return !$this->wasQuote && "," === $this->inputCurrentChar;
    }

    /**
     * Returns true, when got quot
     * @return bool
     */
    private function symbolIsQuot(): bool
    {
        return "\"" === $this->inputCurrentChar;
    }

    /**
     * Returns false, when it is not row divider
     * @return bool
     */
    private function symbolIsNotRowDivider(): bool
    {
        return $this->wasQuote || "\n" !== $this->inputCurrentChar;
    }
}