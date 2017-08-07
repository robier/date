<?php

namespace Robier;

use DateTime;
use DateTimeZone;
use Robier\Date\Offset;
use Robier\Date\Range;

/**
 * Simple wrapper for date concept for holding year, month and year values without timezones.
 *
 * This class is immutable.
 */
class Date
{
    /**
     * @var int Integer representation of current date in format `Ymd` ie. `19911114` for date `1991-11-14`.
     */
    protected $integer;

    /**
     * @var int Year of current Date.
     */
    protected $year;

    /**
     * @var int Month of current Date.
     */
    protected $month;

    /**
     * @var int Day of current Date.
     */
    protected $day;

    /**
     * @param int $year Year for date.
     * @param int $month Month for date.
     * @param int $day Day for date.
     */
    public function __construct(int $year, int $month = 1, int $day = 1)
    {
        $this->integer = (int)sprintf('%04d%02d%02d', $year, $month, $day);

        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    /**
     * Returns date offset manager
     *
     * @return Offset
     */
    public function offset(): Offset
    {
        return new Offset($this);
    }

    /**
     * Adds provided number of days and returns new instance of Date.
     *
     * @param int $offset Number of days current Date will be incremented.
     *
     * @return Date
     */
    public function next(int $offset = 1): self
    {
        return $this->offset()->day($offset);
    }

    /**
     * Subtracts provided number of days and returns new instance of Date.
     *
     * @param int $offset Number of days current Date will be subtracted.
     *
     * @return Date
     */
    public function previous(int $offset = 1): self
    {
        return $this->offset()->day( -1 * abs($offset));
    }

    /**
     * Gets DateTime representation of current Date.
     *
     * @param DateTimeZone|null $zone TimeZone is passed to new instance of DateTime
     *
     * @return DateTime
     */
    public function toDateTime(DateTimeZone $zone = null): DateTime
    {
        return DateTime::createFromFormat('Ymd', $this->integer, $zone);
    }

    /**
     * Get integer representation of current Date. Handy for comparison.
     *
     * @return int
     */
    public function toInteger(): int
    {
        return $this->integer;
    }

    /**
     * Get year component of Date.
     *
     * @return int
     */
    public function year(): int
    {
        return $this->year;
    }

    /**
     * Get month component of Date.
     *
     * @return int
     */
    public function month(): int
    {
        return $this->month;
    }

    /**
     * Get day component of Date.
     *
     * @return int
     */
    public function day(): int
    {
        return $this->day;
    }

    /**
     * Get string representation of Date in format Y-m-d.
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf('%04d-%02d-%02d', $this->year(), $this->month(), $this->day());
    }

    /**
     * Magic method that allows Date object to be casted to string.
     *
     * @see toString()
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Get Generator containing all dates between current and provided date. Starting with current date to $end Date.
     *
     * @param Date $end End date can be smaller than current Date.
     *
     * @return Range
     */
    public function to(Date $end): Range
    {
        return new Range($this, $end);
    }
}
