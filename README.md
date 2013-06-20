When
====
[![Build Status](https://secure.travis-ci.org/Pause-Inc/When.png)](http://travis-ci.org/Pause-Inc/When)

Date/Calendar recursion library for PHP

Author: Thomas Planer

---
###About
After a comprehensive search I couldn't find a PHP library which could handle recursive dates.
There is: [http://phpicalendar.org/][6] however it would have been extremely difficult to extract the recursion
portion of the script from the application.

Oddly, there are extremely good date recursion libraries for both Ruby and Python:

Ruby: [http://github.com/seejohnrun/ice_cube][1]

Python: [http://labix.org/python-dateutil][2]

Since I couldn't find an equivalent for PHP I created [When][3].

---
###Unit Tests

Tests were written in PHPUnit ([http://www.phpunit.de/][4])

Initial set of tests were created from the examples found within RFC5545 ([http://tools.ietf.org/html/rfc5545][5]).

-----------------------------------
###Documentation

Initializing the class

    $when = new Recurrence();

Once you have initialized the class you can create a recurring event by calling on the recur method

    $when->recur(<DateTime object|valid Date string>, <yearly|monthly|weekly|daily>);

You can limit the number of dates to find by specifying a limit():

	$when->limit(<int>);

Alternatively you can specify an end date:

	$when->until(<DateTime object|valid Date String>);

Note: the end date does not have to match the recurring pattern.

Note: the script will stop returning results when either the limit or the end date is met.

More documentation to come, please take a look at the unit tests for an understanding of what the class is capable of.

---
###Examples (take a look at the unit tests for more examples)

The next 5 occurrences of Friday the 13th:

	$r = new Recurrence();
	$r->recur(new DateTime(), 'monthly')
	  ->count(5)
	  ->byday(array('FR'))
	  ->bymonthday(array(13));

	while($result = $r->next())
	{
		echo $result->format('c') . '<br />';
	}

Every four years, the first Tuesday after a Monday in November, for the next 20 years (U.S. Presidential Election day):

	// this is the next election date
	$start = new DateTime('2012-09-06');

	$r = new Recurrence();
	$r->recur($start, 'yearly')
	  ->until($start->modify('+20 years'))
	  ->interval(4)
	  ->bymonth(array(11))
	  ->byday(array('TU'))
	  ->bymonthday(array(2,3,4,5,6,7,8));

	while($result = $r->next())
	{
		echo $result->format('c') . '<br />';
	}

You can now pass raw RRULE's to the class:

	$r = new Recurrence();
	$r->recur('19970922T090000')->rrule('FREQ=MONTHLY;COUNT=6;BYDAY=-2MO');

	while($result = $r->next())
	{
		echo $result->format('c') . '<br />';
	}

**Warnings:**

* If you submit a pattern which has no results the script will loop infinitely.
* If you do not specify an end date (until) or a count for your pattern you must limit the number of results within your script to avoid an infinite loop.

---
###Contributing

If you would like to contribute please create a fork and upon making changes submit a pull request.

Please ensure 100% pass of unit tests before submitting a pull request.

There are 78 tests, 1410 assertions currently.

    >>>phpunit --verbose tests
	PHPUnit 3.4.15 by Sebastian Bergmann.

	tests
	 When_Core_Tests
	 ..

	 When_Daily_Rrule_Test
	 .....

	 When_Daily_Test
	 .....

	 When_Iterator_Tests
	 ..

	 When_Monthly_Rrule_Test
	 ..............

	 When_Monthly_Test
	 ..............

	 When_Weekly_Rrule_Test
	 ........

	 When_Weekly_Test
	 ........

	 When_Rrule_Test
	 ..........

	 When_Yearly_Test
	 ..........

	Time: 2 seconds, Memory: 6.00Mb

	OK (78 tests, 1410 assertions)

---

  [1]: http://github.com/seejohnrun/ice_cube
  [2]: http://labix.org/python-dateutil
  [3]: http://github.com/tplaner/When
  [4]: http://www.phpunit.de/
  [5]: http://tools.ietf.org/html/rfc5545
  [6]: http://phpicalendar.org/
