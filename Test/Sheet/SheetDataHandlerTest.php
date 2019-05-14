<?php

declare(strict_types=1);

namespace Test\Sheet;

use \PHPUnit\Framework\TestCase;
use Sheet\SheetDataHandler;

class SheetDataHandlerTest extends TestCase
{
    public function testFlattenSimpleArray(): void
    {
        $array = ['a', 'b', [[['x'], 'y', 'z']], [['p']]];

        $sheetDataHandler = new SheetDataHandler();

        $flatArray = $sheetDataHandler->flattenArray($array);

        $this->assertCount(6, $flatArray, 'Not all nested values where flattened');
    }

    public function testCalcArraySheetColumnRange(): void
    {
        $sheetDataHandler = new SheetDataHandler();

        $arrayRange = $sheetDataHandler->calcArraySheetColumnRange([1,1,1,1,1,1,1,1]);

        $this->assertEquals('A1:I1', $arrayRange);
    }
}
