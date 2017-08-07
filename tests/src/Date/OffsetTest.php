<?php

namespace Robier\Date\Tests\Date;


use Robier\Date\Offset;
use PHPUnit\Framework\TestCase;
use Robier\Date\Tests\Mocks;

class OffsetTest extends TestCase
{
    use Mocks;

    public function dataProviderForYear()
    {
        return
            [
                ['1991-11-14', 1, '1992-11-14'],
                ['1991-11-14', 5, '1996-11-14'],
                ['1991-11-14', -3, '1988-11-14'],
                ['1991-11-14', 21, '2012-11-14'],
            ];
    }

    public function dataProviderForMonth()
    {
        return
            [
                ['1991-11-14', 1, '1991-12-14'],
                ['1991-11-14', 5, '1992-04-14'],
                ['1991-11-14', -3, '1991-08-14'],
                ['1991-11-14', 21, '1993-08-14'],
            ];
    }

    public function dataProviderForDay()
    {
        return
            [
                ['1991-11-14', 1, '1991-11-15'],
                ['1991-11-14', 5, '1991-11-19'],
                ['1991-11-14', -3, '1991-11-11'],
                ['1991-11-14', 21, '1991-12-05'],
            ];
    }

    public function dataProviderMethodNames()
    {
        return
            [
                ['day', 'month', 'year']
            ];
    }

    /**
     * @dataProvider dataProviderForYear
     *
     * @param string $currentDate
     * @param int $offset
     * @param string $resultDate
     */
    public function testYearMethod(string $currentDate, int $offset, string $resultDate): void
    {
        $testDate = $this->mockDate($currentDate);

        $date = (new Offset($testDate))->year($offset);

        $this->assertEquals($resultDate, $date->toString());
    }

    /**
     * @dataProvider dataProviderForMonth
     *
     * @param string $currentDate
     * @param int $offset
     * @param string $resultDate
     */
    public function testMonthMethod(string $currentDate, int $offset, string $resultDate): void
    {
        $testDate = $this->mockDate($currentDate);

        $date = (new Offset($testDate))->month($offset);

        $this->assertEquals($resultDate, $date->toString());
    }

    /**
     * @dataProvider dataProviderForDay
     *
     * @param string $currentDate
     * @param int $offset
     * @param string $resultDate
     */
    public function testMonthDay(string $currentDate, int $offset, string $resultDate): void
    {
        $testDate = $this->mockDate($currentDate);

        $date = (new Offset($testDate))->day($offset);

        $this->assertEquals($resultDate, $date->toString());
    }

    /**
     * @dataProvider dataProviderMethodNames
     *
     * @param string $methodName
     */
    public function testValidation(string $methodName)
    {
        $testDate = $this->mockDate('1991-11-14');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Offset can not be 0');

        (new Offset($testDate))->{$methodName}(0);
    }
}
