<?php

namespace Robier\Date\Tests;

use DateInterval;
use DateTimeImmutable;
use Robier\Date;

trait Mocks
{
    /**
     * @param string $date
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Date
     */
    protected function mockDate(string $date)
    {
        $dateMock = $this->stubDate();

        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d', $date);

        $dateMock->method('day')->willReturn((int) $dateTime->format('j'));
        $dateMock->method('month')->willReturn((int) $dateTime->format('n'));
        $dateMock->method('year')->willReturn((int) $dateTime->format('Y'));

        $dateMock->method('toDateTime')->willReturn($dateTime);

        $dateMock->method('next')->willReturnCallback(function (int $number = 1) use ($dateTime) {
            $newDateTime = $dateTime->add(new DateInterval(sprintf('P%dD', $number)));

            return $this->mockDate($newDateTime->format('Y-m-d'));
        });

        $dateMock->method('previous')->willReturnCallback(function (int $number = 1) use ($dateTime) {
            $newDateTime = $dateTime->sub(new DateInterval(sprintf('P%dD', $number)));

            return $this->mockDate($newDateTime->format('Y-m-d'));
        });

        $dateMock->method('__toString')->willReturn($date);
        $dateMock->method('toString')->willReturn($date);
        $dateMock->method('toInteger')->willReturn((int) $dateTime->format('Ymd'));

        return $dateMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Date
     */
    protected function stubDate()
    {
        return $this->createMock(Date::class);
    }



}
