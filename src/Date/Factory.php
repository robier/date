<?php

namespace Robier\Date;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;
use Robier\Date;

/**
 * Factory for Date object for easier working with Date object.
 */
abstract class Factory
{
    /**
     * Factory class can not be constructed.
     */
    protected function __construct(){}

    /**
     * Creates new instance of Date by provided data.
     *
     * @param int $year Year of the date.
     * @param int $month Month of the date.
     * @param int $day Day of the date.
     *
     * @return Date
     */
    public static function new(int $year, int $month, int $day): Date
    {
        return new Date($year, $month, $day);
    }

    /**
     * Creates representation of date by DateTimeInterface instance.
     *
     * @param DateTimeInterface $dateTime Can be DateTime or DateTimeImmutable instance.
     *
     * @return Date
     */
    public static function dateTime(DateTimeInterface $dateTime): Date
    {
        $year = (int)$dateTime->format('Y');
        $month = (int)$dateTime->format('n');
        $day = (int)$dateTime->format('j');

        return static::new($year, $month, $day);
    }

    /**
     * Creates representation of date by given date. Handy for creating Date object from string created with
     * Date::toString().
     *
     * @see Date::toString()
     *
     * @param string $date Only valid format of date is Y-m-d ie. `1991-11-14`.
     *
     * @return Date
     */
    public static function string(string $date): Date
    {
        $dateTime = DateTime::createFromFormat('Y-m-d', $date);

        if (is_bool($dateTime)) {
            throw new InvalidArgumentException('Please provide string in yyyy-mm-dd format');
        }

        return static::dateTime($dateTime);
    }

    /**
     * Returns 0 Date instance
     *
     * @return Date
     */
    public static function zero(): Date
    {
        return static::new(0, 0, 0);
    }

    /**
     * Creates representation of date according to the ISO 8601 standard - using weeks and day offsets rather
     * than specific dates.
     *
     * @param int $year Year of date.
     * @param int $week Week offset.
     * @param int $day Day offset of provided week.
     *
     * @return Date
     */
    public static function iso(int $year, int $week, int $day = 1): Date
    {
        return static::dateTime((new DateTime())->setISODate($year, $week, $day));
    }

    /**
     * Creates representation of date for today.
     *
     * @param DateTimeZone|null $dateTimeZone
     *
     * @return Date
     */
    public static function today(DateTimeZone $dateTimeZone = null): Date
    {
        return static::dateTime(new DateTime('now', $dateTimeZone));
    }

    /**
     * Creates representation of date for tomorrow.
     *
     * @param DateTimeZone|null $dateTimeZone
     *
     * @return Date
     */
    public static function tomorrow(DateTimeZone $dateTimeZone = null): Date
    {
        return self::today($dateTimeZone)->next();
    }

    /**
     * Creates representation of date for yesterday
     *
     * @param DateTimeZone|null $dateTimeZone
     *
     * @return Date
     */
    public static function yesterday(DateTimeZone $dateTimeZone = null): Date
    {
        return self::today($dateTimeZone)->previous();
    }
}
