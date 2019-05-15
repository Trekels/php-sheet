<?php

declare(strict_types=1);

namespace Sheet;

class SheetDataFormatter
{
    public function calcArraySheetColumnRange(array $array): string
    {
        return sprintf('%s1:%s1', $this->numberToLetter(0), $this->numberToLetter(count($array)));
    }

    public function numberToLetter(int $number): string
    {
        $numeric = $number % 26;
        $letter = chr(65 + $numeric);
        $next = (int)($number / 26);

        return ($next > 0) ? $this->numberToLetter($next): $letter;
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
