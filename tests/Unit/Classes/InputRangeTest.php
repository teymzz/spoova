<?php

namespace spoova\mi\tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use spoova\mi\core\tools\Input;

/**
 * Covers Input's range validation: the per value "range" option and the default_range()
 * method that applies one to every value that follows.
 *
 * The cases here are the ones the documentation shows, so a change that quietly breaks a
 * documented sample fails a test rather than being found by a reader.
 */
class InputRangeTest extends TestCase
{
    private Input $input;

    protected function setUp(): void
    {
        $this->input = new Input;
    }

    /* ---- a range supplied with the value ---- */

    public function test_a_value_within_the_supplied_range_is_returned(): void
    {
        $this->assertSame('yes', $this->input->set('yes', ['type' => 'string', 'range' => ['yes', 'no']]));
    }

    public function test_a_value_outside_the_supplied_range_is_rejected(): void
    {
        $this->assertFalse($this->input->set('foo', ['type' => 'string', 'range' => ['yes', 'no']]));
    }

    /* ---- a range applied to everything that follows ---- */

    public function test_a_default_range_applies_to_a_value_that_supplies_none(): void
    {
        $this->input->default_range([20, 30, 40, 50]);

        $this->assertSame('30', $this->input->set(30, ['type' => 'number']));
        $this->assertFalse($this->input->set(35, ['type' => 'number']));
    }

    public function test_a_supplied_range_wins_over_the_default_one(): void
    {
        $this->input->default_range([20, 30]);

        $this->assertSame('9', $this->input->set(9, ['type' => 'number', 'range' => [9, 10]]));
    }

    public function test_a_default_range_is_removed_by_passing_null(): void
    {
        /* default_range(null) used to leave the stored range in place, so every later value
           was still checked against a range the caller had just removed */
        $this->input->default_range([20, 30, 40, 50]);
        $this->assertFalse($this->input->set(35, ['type' => 'number']));

        $this->input->default_range(null);

        $this->assertSame('35', $this->input->set(35, ['type' => 'number']));
    }

    public function test_a_default_range_can_be_replaced_after_being_removed(): void
    {
        $this->input->default_range([20, 30]);
        $this->input->default_range(null);
        $this->input->default_range(['a', 'b']);

        $this->assertSame('a', $this->input->set('a', ['type' => 'string']));
        $this->assertFalse($this->input->set('c', ['type' => 'string']));
    }

    /* ---- a range of one option ---- */

    public function test_a_single_option_may_be_supplied_on_its_own(): void
    {
        // a scalar used to reach in_array() as-is and raise a TypeError
        $this->assertSame('yes', $this->input->set('yes', ['type' => 'string', 'range' => 'yes']));
        $this->assertFalse($this->input->set('no', ['type' => 'string', 'range' => 'yes']));
    }

    public function test_a_single_option_may_be_the_default_range(): void
    {
        // a scalar default range used to be stored but never applied
        $this->input->default_range('yes');

        $this->assertSame('yes', $this->input->set('yes', ['type' => 'string']));
        $this->assertFalse($this->input->set('no', ['type' => 'string']));
    }

    public function test_an_empty_or_absent_range_matches_nothing(): void
    {
        $this->assertFalse($this->input->set('a', ['type' => 'string', 'range' => []]));
        $this->assertFalse($this->input->set('a', ['type' => 'string', 'range' => null]));
    }

    public function test_no_range_is_applied_when_none_was_ever_set(): void
    {
        $this->assertSame('7', $this->input->set(7, ['type' => 'number']));

        // and removing one that was never set leaves the value alone
        $this->input->default_range(null);

        $this->assertSame('7', $this->input->set(7, ['type' => 'number']));
    }
}
