<?php

namespace When\Tests;

use When\When;

class CoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidDate()
    {
        $r = new When();
        $r->recur('NOT A VALID TIME STAMP', 'yearly');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidFrequencies()
    {
        $r = new When();
        $r->recur('2000-01-01', 'yearlyy');
    }
}
