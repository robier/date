<?php

namespace Robier\Date\Tests\Date;

use Robier\Date;
use Robier\Date\Range;
use PHPUnit\Framework\TestCase;
use Robier\Date\Tests\Mocks;

class RangeTest extends TestCase
{
    use Mocks;

    public function dataProviderForRange()
    {
        return
            [
                ['1991-11-14', '1991-11-17', 4],
                ['1991-11-20', '1991-11-14', 7],
                ['1991-11-14', '1991-11-14', 1],
            ];
    }

    /**
     * @dataProvider dataProviderForRange
     *
     * @param string $start
     * @param string $end
     * @param int $sum
     */
    public function testRange(string $start, string $end, int $sum)
    {
        $range = new Range($this->mockDate($start), $this->mockDate($end));

        $count = 0;
        foreach ($range as $key => $data) {
            $this->assertInstanceOf(Date::class, $data);
            ++$count;
        }

        $this->assertEquals($sum, $count);
    }
}
