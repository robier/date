<?php

namespace Robier\Date\Tests;

use PHPUnit\Framework\TestCase;
use Robier\Date;

class DateTest extends TestCase
{
    public function dataProviderDates(): array
    {
        return
        [
            [1991, 11, 14],
            [1991, 11, 15],
            [1991, 11, 16],
            [1991, 11, 17],
            [1991, 11, 18],
        ];
    }

    /**
     * @dataProvider dataProviderDates
     *
     * @param int $year
     * @param int $month
     * @param int $day
     */
    public function testGetters(int $year, int $month, int $day): void
    {
        $date = new Date($year, $month, $day);

        $this->assertEquals($day, $date->day());
        $this->assertEquals($month, $date->month());
        $this->assertEquals($year, $date->year());

        $this->assertEquals(sprintf('%04d%02d%02d', $year, $month, $day), $date->toInteger());
    }

    public function testNextMethod(): void
    {
        $date = new Date(1991, 11, 14);

        $this->assertEquals(15, $date->next(1)->day());
        $this->assertEquals(19, $date->next(5)->day());
    }

    public function testPreviousMethod(): void
    {
        $date = new Date(1991, 11, 14);

        $this->assertEquals(13, $date->previous(1)->day());
        $this->assertEquals(9, $date->previous(5)->day());
    }

    /**
     * @dataProvider dataProviderDates
     *
     * @param int $year
     * @param int $month
     * @param int $day
     */
    public function testConversation(int $year, int $month, int $day): void
    {
        $date = new Date($year, $month, $day);

        $string = sprintf('%04d-%02d-%02d', $year, $month, $day);
        $integer = (int) sprintf('%04d%02d%02d', $year, $month, $day);
        $dateTime = $date->toDateTime();

        $this->assertEquals($string, (string) $date);
        $this->assertEquals($string, $date->toString());
        $this->assertEquals($integer, $date->toInteger());
        $this->assertEquals($string, $dateTime->format('Y-m-d'));
    }

    public function testToDateTimeMethod()
    {
        $this->assertInstanceOf(\DateTimeInterface::class, (new Date(1991, 11, 14))->toDateTime());
    }

    public function testToMethod()
    {
        $date = new Date(1991, 11, 14);

        $this->assertInstanceOf(Date\Range::class, $date->to(new Date(1991, 12, 1)));
    }

    public function testOffsetMethod()
    {
        $date = new Date(1991, 11, 14);

        $this->assertInstanceOf(Date\Offset::class, $date->offset());
    }
}
