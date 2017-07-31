<?php

namespace Robier\Date\Tests\Date;

use DateTimeZone;
use InvalidArgumentException;
use Robier\Date\Factory;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function dataProviderForTimeZones(): \Generator
    {
        yield [null, 'DateTimeZone not provided'];

        $timezoneIdentifiers = DateTimeZone::listIdentifiers();

        foreach ($timezoneIdentifiers as $identifier) {
            yield [new DateTimeZone($identifier), sprintf('DateTimeZone for country %s', $identifier)];
        }
    }

    /**
     * @dataProvider dataProviderForTimeZones
     *
     * @param DateTimeZone|null $timeZone
     * @param string            $description
     */
    public function testTodayMethod(DateTimeZone $timeZone = null, string $description): void
    {
        $date = Factory::today($timeZone);

        $dateTime = new \DateTime('now', $timeZone);

        $this->assertEquals($dateTime->format('Y-m-d'), $date->toDateTime()->format('Y-m-d'), $description);
    }

    /**
     * @dataProvider dataProviderForTimeZones
     *
     * @param DateTimeZone|null $timeZone
     * @param string            $description
     */
    public function testTomorrowMethod(DateTimeZone $timeZone = null, string $description): void
    {
        $date = Factory::tomorrow($timeZone);
        $dateTime = (new \DateTime('now', $timeZone))->modify('+1 day');

        $this->assertEquals($dateTime->format('Y-m-d'), $date->toDateTime()->format('Y-m-d'), $description);
    }

    /**
     * @dataProvider dataProviderForTimeZones
     *
     * @param DateTimeZone|null $timeZone
     * @param string            $description
     */
    public function testYesterdayMethod(DateTimeZone $timeZone = null, string $description): void
    {
        $date = Factory::yesterday($timeZone);
        $dateTime = (new \DateTime('now', $timeZone))->modify('-1 day');

        $this->assertEquals($dateTime->format('Y-m-d'), $date->toDateTime()->format('Y-m-d'), $description);
    }

    public function testStringMethod(): void
    {
        $date = Factory::string('1991-11-14');

        $this->assertEquals(1991, $date->year());
        $this->assertEquals(11, $date->month());
        $this->assertEquals(14, $date->day());
    }

    public function testStringMethodException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Please provide string in yyyy-mm-dd format');

        Factory::string('14-11-1991');
    }

    public function dataProviderForIsoMethod(): array
    {
        return
        [
            ['1991-11-14', 1991, 46, 4],
        ];
    }

    /**
     * @dataProvider dataProviderForIsoMethod
     *
     * @param string $string
     * @param int $year
     * @param int $week
     * @param int $day
     */
    public function testIsoMethod(string $string, int $year, int $week, int $day): void
    {
        $date = Factory::iso($year, $week, $day);

        $this->assertEquals($string, $date->toString());
    }
}
