<?php
/**
 * When
 * Copyright (c) Thomas Planer
 */

namespace When;

/**
 * Implements PHP's Object Iteration Interface (http://us.php.net/Iterator &
 * http://php.net/manual/en/class.iterator.php) so you can use the object
 * within a foreach loop.
 *
 * Thanks to Andrew Collington for suggesting the implementation of an
 * Iterator and supplying the base code for it.
 *
 * @author Thomas Planer <tplaner@gmail.com>
 * @author Ryan Kadwell <ryan@pause.ca>
 */
class Iterator extends Recurrence implements \Iterator
{
    /**
     * store the current position in the array
     * @var integer
     */
    protected $position = 0;

    /**
     * store an individual result if caching is disabled
     */
    protected $result;

    /**
     * store all of the results
     * @var array
     */
    protected $results = array();

    protected $cache = false;

    /**
     * caching the results will cause the script to use more memory but less
     * cpu (should also perform quicker) results should always be the same
     * regardless of cache
     *
     * @param boolean $cache Do we want to cache results
     */
    public function __construct($cache = false)
    {
        parent::__construct();

        $this->position = 0;
        $this->results = array();
        $this->cache = $cache;
    }

    public function rewind()
    {
        if ($this->cache) {
            $this->position = 0;
        } else {
            // reset the counter and try_date in the parent class
            $this->counter = 0;
            $this->try_date = clone $this->start_date;
        }
    }

    public function current()
    {
        if ($this->cache === true) {
            return $this->results[$this->position];
        } else {
            return $this->result;
        }
    }

    /**
     * only used if caching is enabled
     *
     * @return integer
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * only used if caching is enabled
     */
    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        if ($this->cache === true) {
            // check to see if the current position has already been stored
            if (!empty($this->results[$this->position])) {
                return isset($this->results[$this->position]);
            } elseif ($next_date = parent::next()) {
                // if it hasn't been found, check to see if there are more
                // dates
                $this->results[] = $next_date;

                return isset($next_date);
            }
        } else {
            // check to see if there is another result and set that as the
            // result
            if ($next_date = parent::next()) {
                $this->result = $next_date;

                return isset($this->result);
            }
        }

        // end the foreach loop when all options are exhausted
        return false;
    }

    public function enableCache($cache)
    {
        $this->cache = $cache;
    }
}
