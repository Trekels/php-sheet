<?php

declare(strict_types=1);

namespace Sheet;

class SheetDataHandler
{
    public function calcArraySheetColumnRange(array $array): string
    {
        return sprintf('%s1:%s1', $this->numberToLetter(0), $this->numberToLetter(count($array)));
    }

    public function numberToLetter(int $length): string
    {
        $numeric = $length % 26;
        $letter = chr(65 + $numeric);
        $rest = (int)($length / 26);

        return ($rest > 0) ? $this->numberToLetter($rest): $letter;
    }

    public function flattenArray(array $array, array $result = null): array
    {
        foreach ($array as $entry) {
            if (is_array($entry)) {
                $result = $this->flattenArray($entry, $result);

                continue;
            }

            $result[] = $entry;
        }

        return $result;
    }
}
