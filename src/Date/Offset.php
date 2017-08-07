<?php

namespace Robier\Date;

use DateInterval;
use Robier\Date;

/**
 * Easier adding/subtracting days/months/years from Date object.
 */
class Offset
{
    protected const DAY   = 'D';
    protected const MONTH = 'M';
    protected const YEAR  = 'Y';

    /**
     * @var Date
     */
    protected $date;

    /**
     * Offset constructor.
     *
     * @param Date $date
     */
    public function __construct(Date $date)
    {
        $this->date = $date;
    }

    /**
     * Change provided date by x years.
     *
     * @param int $offset Positive or negative number. Can not be 0.
     *
     * @return Date
     */
    public function year(int $offset): Date
    {
        return $this->calculate($offset, static::YEAR);
    }

    /**
     * Change provided date by x months.
     *
     * @param int $offset
     *
     * @return Date
     */
    public function month(int $offset): Date
    {
        return $this->calculate($offset, static::MONTH);
    }

    /**
     * Change provided date by x days.
     *
     * @param int $offset Positive or negative number. Can not be 0.
     *
     * @return Date
     */
    public function day(int $offset): Date
    {
        return $this->calculate($offset, static::DAY);
    }

    /**
     * Calculate new date.
     *
     * @param int $offset Number of years/months/days.
     * @param string $type One of class defined constants.
     *
     * @return Date
     */
    protected function calculate(int $offset, string $type): Date
    {
        $this->validateOffset($offset);

        $interval = $this->interval($offset, $type);

        if ($offset < 0) {
            return Factory::dateTime($this->date->toDateTime()->sub($interval));
        }

        return Factory::dateTime($this->date->toDateTime()->add($interval));
    }

    /**
     * Offset can be positive and negative number, it should never be 0.
     *
     * @param int $offset Provided offset.
     */
    protected function validateOffset(int $offset): void
    {
        if ($offset === 0) {
            throw new \InvalidArgumentException('Offset can not be 0');
        }
    }

    /**
     * Create new dateInterval instance by provided offset and offset type.
     *
     * @param int $offset
     * @param string $type
     *
     * @return DateInterval
     */
    protected function interval(int $offset, string $type): DateInterval
    {
        $offset = abs($offset);

        return new DateInterval(sprintf('P%d%s', $offset, $type));
    }

}
