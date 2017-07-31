<?php

namespace Robier\Date;

use Iterator;
use Robier\Date;

/**
 * Iterator implementation of date range
 */
class Range implements Iterator
{
    /**
     * @var Date
     */
    protected $start;

    /**
     * @var Date
     */
    protected $current;

    /**
     * @var Date
     */
    protected $end;

    /**
     * @var bool
     */
    protected $next = true;

    /**
     * @var int
     */
    protected $key = 0;

    /**
     * @param Date $start Start Date.
     * @param Date $end End Date.
     */
    public function __construct(Date $start, Date $end)
    {
        if ($start->toInteger() > $end->toInteger()) {
            $this->next = false;
        }

        $this->start = $start;
        $this->current = $start;
        $this->end = $end;
    }

    /**
     * Iterator implementation of current method.
     *
     * @return Date
     */
    public function current(): Date
    {
        return $this->current;
    }

    /**
     * Iterator implementation of next method.
     */
    public function next(): void
    {
        ++$this->key;

        if ($this->next) {
            $this->current = $this->current->next();
        } else {
            $this->current = $this->current->previous();
        }
    }

    /**
     * Iterator implementation of key method.
     *
     * @return int
     */
    public function key(): int
    {
        return $this->key;
    }

    /**
     * Iterator implementation of valid method.
     *
     * @return bool
     */
    public function valid(): bool
    {
        if ($this->next) {
            return $this->current->toInteger() <= $this->end->toInteger();
        }

        return $this->current->toInteger() >= $this->end->toInteger();
    }

    /**
     * Iterator implementation of rewind method.
     */
    public function rewind(): void
    {
        $this->key = 0;
        $this->current = $this->start;
    }
}
