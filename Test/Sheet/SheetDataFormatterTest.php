<?php

declare(strict_types=1);

namespace Test\Sheet;

use \PHPUnit\Framework\TestCase;
use Sheet\SheetDataFormatter;

class SheetDataFormatterTest extends TestCase
{
    public function testFlattenSimpleArray(): void
    {
        $array = ['a', 'b', [[['x'], 'y', 'z']], [['p']]];

        $sheetDataFormatter = new SheetDataFormatter();

        $flatArray = $sheetDataFormatter->flattenArray($array);

        $this->assertCount(6, $flatArray, 'Not all nested values where flattened');
    }

    public function testCalcArraySheetColumnRange(): void
    {
        $sheetDataFormatter = new SheetDataFormatter();

        $arrayRange = $sheetDataFormatter->calcArraySheetColumnRange([1,1,1,1,1,1,1,1]);

        $this->assertEquals('A1:I1', $arrayRange);
    }
}
