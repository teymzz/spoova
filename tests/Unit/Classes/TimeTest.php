<?php

namespace spoova\mi\tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use spoova\mi\core\classes\Time;

/**
 * Covers Time, which converts a span of seconds into a single unit and renders a
 * past date as "time ago".
 */
class TimeTest extends TestCase
{
    /* ---- secondsTo: units ---- */

    public function test_seconds_convert_to_each_unit(): void
    {
        $this->assertSame('2', Time::secondsTo(120, 'minutes'));
        $this->assertSame('2', Time::secondsTo(7200, 'hours'));
        $this->assertSame('2', Time::secondsTo(172800, 'days'));
    }

    /**
     * Every spelling of a unit is a name for the same divisor — a caller writing
     * 'm' and a caller writing 'minutes' must not get different numbers.
     */
    public function test_the_spellings_of_a_unit_agree_with_each_other(): void
    {
        $this->assertSame(['3', '3', '3', '3', '3'], [
            Time::secondsTo(180, 'minutes'), Time::secondsTo(180, 'minute'),
            Time::secondsTo(180, 'mins'),    Time::secondsTo(180, 'min'),
            Time::secondsTo(180, 'm'),
        ]);

        $this->assertSame(['3', '3', '3', '3', '3'], [
            Time::secondsTo(10800, 'hours'), Time::secondsTo(10800, 'hour'),
            Time::secondsTo(10800, 'hrs'),   Time::secondsTo(10800, 'hr'),
            Time::secondsTo(10800, 'h'),
        ]);
    }

    public function test_a_scale_is_read_regardless_of_case(): void
    {
        $this->assertSame('2', Time::secondsTo(120, 'MINUTES'));
        $this->assertSame('2', Time::secondsTo(120, 'Minutes'));
    }

    /**
     * 'month' used to match no branch at all — the divisor stayed undefined and the
     * division raised a DivisionByZeroError instead of reporting a month.
     */
    public function test_months_are_a_readable_scale(): void
    {
        $month = (365.2425 * 86400) / 12;

        $this->assertSame('1', Time::secondsTo((int) $month, 'month'));
        $this->assertSame('1', Time::secondsTo((int) $month, 'months'));
        $this->assertSame('1', Time::secondsTo((int) $month, 'mon'));
    }

    /**
     * A month is a twelfth of the year the class uses, so reading one span both ways
     * has to stay in step — a flat 30-day month against a 365-day year would drift.
     */
    public function test_a_year_reads_as_twelve_months(): void
    {
        $year = (int) (365.2425 * 86400);

        $this->assertSame('1', Time::secondsTo($year, 'years'));
        $this->assertSame('12', Time::secondsTo($year, 'months'));
    }

    /* ---- secondsTo: rounding ---- */

    /**
     * The default reports whole units only, so a span that has not reached the next
     * unit still reads as the current one rather than being rounded up past it.
     */
    public function test_by_default_the_fraction_is_discarded(): void
    {
        $this->assertSame('1', Time::secondsTo(90, 'minutes'));
        $this->assertSame('1', Time::secondsTo(119, 'minutes'));
    }

    public function test_a_round_of_zero_rounds_to_the_nearest_whole_unit(): void
    {
        $this->assertSame('2', Time::secondsTo(90, 'minutes', 0));
        $this->assertSame('1', Time::secondsTo(89, 'minutes', 0));
    }

    public function test_decimal_places_are_reported_when_asked_for(): void
    {
        $this->assertSame('1.5', Time::secondsTo(90, 'minutes', 1));
        $this->assertSame('1.25', Time::secondsTo(75, 'minutes', 2));
    }

    /**
     * round() reads a negative precision as a request to round off whole tens, which
     * would turn 90 seconds into 0 minutes — a nonsensical precision is clamped instead.
     */
    public function test_a_negative_precision_does_not_round_away_the_value(): void
    {
        $this->assertSame('2', Time::secondsTo(90, 'minutes', -3));
    }

    /* ---- secondsTo: what cannot be read ---- */

    /**
     * A zero span has no reading, and a span cannot run backwards — both report the
     * same FALSE rather than a negative duration becoming a second way of saying nothing.
     */
    public function test_a_zero_or_negative_span_reports_false(): void
    {
        $this->assertFalse(Time::secondsTo(0, 'minutes'));
        $this->assertFalse(Time::secondsTo(-50, 'minutes'));
        $this->assertFalse(Time::secondsTo(-5000, 'hours', 2));
    }

    public function test_an_unknown_scale_reports_false(): void
    {
        $this->assertFalse(Time::secondsTo(60, 'fortnights'));
        $this->assertFalse(Time::secondsTo(60, ''));
        $this->assertFalse(Time::secondsTo(60, null));
    }

    public function test_a_value_that_is_not_a_number_reports_false(): void
    {
        $this->assertFalse(Time::secondsTo('not a number', 'minutes'));
        $this->assertFalse(Time::secondsTo([], 'minutes'));
    }

    public function test_a_numeric_string_is_read_as_a_number(): void
    {
        $this->assertSame('2', Time::secondsTo('120', 'minutes'));
    }

    /* ---- distanceFrom ---- */

    public function test_a_moment_ago_reads_as_just_now(): void
    {
        $this->assertSame('just now', Time::distanceFrom(date('Y-m-d H:i:s', time() - 5)));
    }

    public function test_a_past_date_reads_as_time_ago(): void
    {
        $this->assertSame('3 days ago ', Time::distanceFrom(date('Y-m-d H:i:s', time() - 86400 * 3)));
        $this->assertSame('4 hours ago ', Time::distanceFrom(date('Y-m-d H:i:s', time() - 3600 * 4)));
        $this->assertSame('10 mins ago ', Time::distanceFrom(date('Y-m-d H:i:s', time() - 60 * 10)));
    }

    public function test_a_timestamp_reads_the_same_as_the_date_it_stands_for(): void
    {
        $moment = time() - 86400 * 3;

        $this->assertSame(
            Time::distanceFrom(date('Y-m-d H:i:s', $moment)),
            Time::distanceFrom($moment, 'timestamp')
        );
    }

    /**
     * The largest unit that fits is the one reported — a span of days must not be
     * spelled out in the hours or minutes it also contains.
     */
    public function test_only_the_largest_unit_that_fits_is_reported(): void
    {
        $reading = Time::distanceFrom(date('Y-m-d H:i:s', time() - (86400 * 2 + 3600 * 5 + 60 * 30)));

        $this->assertSame('2 days ago ', $reading);
    }

    /**
     * The pluralizer used to return the *number* rather than the singular noun when
     * the value was not greater than one, so a single unit printed its count twice
     * ("1 1 ago") instead of naming itself.
     */
    public function test_a_single_unit_is_named_in_the_singular(): void
    {
        $this->assertSame('1 hour ago ', Time::distanceFrom(date('Y-m-d H:i:s', time() - 3600)));
        $this->assertSame('1 day ago ', Time::distanceFrom(date('Y-m-d H:i:s', time() - 86400)));
        $this->assertSame('1 min ago ', Time::distanceFrom(date('Y-m-d H:i:s', time() - 60)));
    }

    /**
     * The years branch was the one reading that never said "ago".
     */
    public function test_a_span_of_years_reads_like_every_other_unit(): void
    {
        $this->assertSame('2 years ago ', Time::distanceFrom(date('Y-m-d H:i:s', strtotime('-2 years -1 day'))));
    }

    public function test_two_times_that_are_the_same_read_as_just_now(): void
    {
        $this->assertSame('just now', Time::distanceFrom(date('Y-m-d H:i:s')));
    }

    /* ---- difference between two times ---- */

    /**
     * setTime() accepted $first and $last but stored neither, so the two spans
     * compared by difference() were always NULL and every reading came back FALSE.
     */
    public function test_the_difference_between_two_times_is_reported_by_unit(): void
    {
        Time::setTime('2020-01-01 00:00:00', '2021-03-05 06:07:08');

        $this->assertSame(1, Time::difference('year'));
        $this->assertSame(2, Time::difference('month'));
        $this->assertSame(4, Time::difference('day'));
        $this->assertSame(6, Time::difference('hour'));
        $this->assertSame(7, Time::difference('minute'));
        $this->assertSame(8, Time::difference('second'));
    }

    public function test_all_reports_every_unit_at_once(): void
    {
        Time::setTime('2020-01-01 00:00:00', '2021-03-05 06:07:08');

        $this->assertSame(
            ['year' => 1, 'month' => 2, 'day' => 4, 'hour' => 6, 'min' => 7, 'sec' => 8],
            Time::difference('all')
        );
    }

    public function test_timestamps_can_be_compared_as_well_as_dates(): void
    {
        Time::setTime(strtotime('2020-01-01 00:00:00'), strtotime('2021-03-05 00:00:00'), 'timestamp');

        $this->assertSame(1, Time::difference('year'));
        $this->assertSame(2, Time::difference('month'));
    }

    /**
     * The readings are static, so a second span has to overwrite the first — a stale
     * year from an earlier comparison must not survive into this one.
     */
    public function test_a_second_comparison_replaces_the_first(): void
    {
        Time::setTime('2010-01-01 00:00:00', '2020-01-01 00:00:00');
        $this->assertSame(10, Time::difference('year'));

        Time::setTime('2020-01-01 00:00:00', '2020-04-01 00:00:00');
        $this->assertSame(0, Time::difference('year'));
        $this->assertSame(3, Time::difference('month'));
    }

    public function test_valid_minute_measures_against_the_span_just_compared(): void
    {
        Time::setTime('2020-01-01 00:00:00', '2020-01-01 00:10:00');
        Time::difference('all');

        $this->assertTrue(Time::valid_minute(15), '10 minutes is inside a 15 minute allowance.');
        $this->assertFalse(Time::valid_minute(5), '10 minutes is outside a 5 minute allowance.');
    }

    /**
     * Anything longer than the allowance fails it, however much longer — an allowance
     * counted in minutes cannot be satisfied by a span measured in days.
     */
    public function test_a_span_larger_than_a_minute_allowance_is_never_valid(): void
    {
        Time::setTime('2020-01-01 00:00:00', '2020-01-03 00:00:00');
        Time::difference('all');

        $this->assertFalse(Time::valid_minute(10000));
    }

    /* ---- convert(): the full difference ---- */

    /**
     * Every branch below the first pluralized against the year, and minutes and
     * seconds both named themselves "hour" — so a span of minutes read as hours.
     */
    public function test_a_diff_names_the_unit_it_actually_measured(): void
    {
        $date = date('Y-m-d H:i:s', time() - 60 * 30);

        $this->assertSame('30 mins, ', Time::convert($date, 'diff'));
    }

    public function test_a_diff_of_one_unit_is_named_in_the_singular(): void
    {
        $date = date('Y-m-d H:i:s', time() - 3600);

        $this->assertSame('1 hour, ', Time::convert($date, 'diff'));
    }
}
