<?php

namespace spoova\mi\tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use spoova\mi\core\tools\Input;

/**
 * Covers Input against the behaviour its documentation describes: data types, character
 * lengths, space and pattern validation, strict mode, error tracking and empty value
 * detection. Range validation is covered separately in InputRangeTest.
 *
 * Each case is taken from a documented sample, so a change that quietly breaks one of the
 * pages fails a test rather than being found by a reader.
 */
class InputTest extends TestCase
{
    private Input $input;

    protected function setUp(): void
    {
        $this->input = new Input;
    }

    /* ---- data types ---- */

    public function test_a_string_is_only_a_string(): void
    {
        $this->assertSame('foo', $this->input->set('foo', ['type' => 'string']));
        $this->assertSame('123', $this->input->set('123', ['type' => 'string']));
        $this->assertFalse($this->input->set(123, ['type' => 'string']));
    }

    public function test_text_accepts_letters_only(): void
    {
        $this->assertSame('foobar', $this->input->set('foobar', ['type' => 'text']));
        $this->assertFalse($this->input->set('foo123', ['type' => 'text']));
    }

    public function test_an_integer_may_be_written_as_a_string_but_not_as_a_decimal(): void
    {
        $this->assertSame('12345', $this->input->set('12345', ['type' => 'integer']));
        $this->assertFalse($this->input->set('abc12', ['type' => 'integer']));
        $this->assertFalse($this->input->set(1332.56, ['type' => 'integer']));
    }

    public function test_a_float_is_not_an_integer(): void
    {
        $this->assertSame('1332.56', $this->input->set(1332.56, ['type' => 'float']));
        $this->assertSame('10.43', $this->input->set('10.43', ['type' => 'float']));
        $this->assertFalse($this->input->set(12345, ['type' => 'float']));
    }

    public function test_numeric_accepts_any_number(): void
    {
        $this->assertSame('1332.56', $this->input->set(1332.56, ['type' => 'numeric']));
        $this->assertFalse($this->input->set('134ab', ['type' => 'numeric']));
    }

    public function test_email_and_url_formats(): void
    {
        $this->assertSame('foo@site.com', $this->input->set('foo@site.com', ['type' => 'email']));
        $this->assertFalse($this->input->set('somesite.com', ['type' => 'email']));

        $this->assertSame('http://foo@abc.com', $this->input->set('http://foo@abc.com', ['type' => 'url']));
        $this->assertFalse($this->input->set('134ab', ['type' => 'url']));
    }

    public function test_string_is_assumed_when_no_type_is_given(): void
    {
        $this->assertSame('abc', $this->input->set('abc'));
        $this->assertFalse($this->input->set(123));
    }

    public function test_a_default_type_applies_until_it_is_removed(): void
    {
        $this->input->default_type('string');

        $this->assertSame('foo', $this->input->set('foo'));
        $this->assertFalse($this->input->set('foo', ['type' => 'number']), 'a supplied type wins');

        $this->input->default_type(null);

        $this->assertSame('abc', $this->input->set('abc'));
    }

    /* ---- patterns ---- */

    public function test_a_pattern_has_to_account_for_the_whole_value(): void
    {
        /* "/[a-zA-Z]+/" matches the letters inside "abc123", which used to let the value
           through even though the documentation reports it as a failure */
        $this->assertSame('abcAJz', $this->input->set('abcAJz', ['type' => 'string', 'pattern' => '/[a-zA-Z]+/']));
        $this->assertFalse($this->input->set('abc123', ['type' => 'string', 'pattern' => '/[a-zA-Z]+/']));
    }

    public function test_a_pattern_may_be_used_without_a_type(): void
    {
        $this->assertSame('abcAJz', $this->input->set('abcAJz', ['pattern' => '/[a-zA-Z]+/']));
        $this->assertFalse($this->input->set('abc123', ['pattern' => '/[a-zA-Z]+/']));
    }

    public function test_a_pattern_keeps_its_modifiers(): void
    {
        // the pattern is used as supplied, so a case insensitive match stays available
        $this->assertSame('ABC', $this->input->set('ABC', ['pattern' => '/[a-z]+/i']));
        $this->assertFalse($this->input->set('ABC', ['pattern' => '/[a-z]+/']));
    }

    public function test_a_pattern_carrying_no_delimiters_is_reported_as_invalid(): void
    {
        /* delimiters belong to the caller, and a pattern written without them is not a
           regular expression at all: it is turned away with a message rather than raising
           a warning from preg_match() */
        $this->assertFalse($this->input->set('abc123', ['pattern' => 'A-Za-z0-9']));
        $this->assertStringContainsString('not a valid regular expression', $this->input->response());
    }

    /* ---- lengths ---- */

    public function test_a_single_length_is_a_maximum(): void
    {
        // this used to reach a framework helper and die wherever the class was used alone
        $this->assertSame('foobar', $this->input->set('foobar', ['type' => 'string', 'length' => 20]));
        $this->assertFalse($this->input->set('foobar', ['type' => 'string', 'length' => 5]));
    }

    public function test_a_pair_of_lengths_is_a_minimum_and_a_maximum(): void
    {
        $this->assertSame('foobar', $this->input->set('foobar', ['type' => 'string', 'length' => [5, 20]]));
        $this->assertFalse($this->input->set('foo', ['type' => 'string', 'length' => [5, 20]]));
    }

    public function test_a_default_length_applies_until_it_is_removed(): void
    {
        $this->input->default_length([5, 20]);

        $this->assertFalse($this->input->set('foo', ['type' => 'string']));

        // default_length() would not take null at all, though removing one is documented
        $this->input->default_length(null);

        $this->assertSame('foo', $this->input->set('foo', ['type' => 'string']));
    }

    /* ---- spaces ---- */

    public function test_spaces_can_be_refused(): void
    {
        $this->assertSame('foobar', $this->input->set('foobar', ['spaces' => false]));
        $this->assertFalse($this->input->set('foo bar', ['spaces' => false]));
    }

    /* ---- strict mode ---- */

    public function test_strict_mode_stops_validating_after_a_failure(): void
    {
        $this->input->strict();

        $this->assertFalse($this->input->set('foobar', ['type' => 'number']), 'fails');
        $this->assertFalse($this->input->set('foobar', ['type' => 'string']), 'skipped');

        $this->input->strict(false);

        $this->assertSame('foobar', $this->input->set('foobar', ['type' => 'string']));
    }

    /* ---- error tracking ---- */

    public function test_response_reports_the_first_failure(): void
    {
        $this->input->set('123', ['type' => 'number']);
        $this->input->set('foo', ['type' => 'string']);
        $this->input->set('foo', ['type' => 'number']);   // first failure
        $this->input->set('bar', ['type' => 'float']);    // second failure

        $this->assertTrue($this->input->error_exists());

        // the later failure used to displace the first one
        $this->assertStringContainsString('number', $this->input->response());
    }

    public function test_an_error_is_kept_against_the_id_it_was_given(): void
    {
        $this->input->id('test1')->set('123', ['type' => 'number']);
        $this->input->id('test2')->set('foo', ['type' => 'number']);
        $this->input->id('test3')->set('bar', ['type' => 'float']);

        $errors = $this->input->error();

        $this->assertArrayNotHasKey('test1', $errors, 'a value that passed leaves no error');
        $this->assertArrayHasKey('test2', $errors);
        $this->assertArrayHasKey('test3', $errors);
        $this->assertSame($errors['test2'], $this->input->error('test2'));
        $this->assertFalse($this->input->error('unknown'));
    }

    /* ---- empty values ---- */

    public function test_empty_values_are_reported_with_their_keys(): void
    {
        $this->assertTrue(Input::arrGetsVoid(['fname' => 'foo', 'lname' => 'bar', 'uname' => '']));
        $this->assertSame(['uname'], Input::voidKeys());
    }

    public function test_each_check_reports_only_its_own_keys(): void
    {
        Input::arrGetsVoid(['uname' => '']);

        // the key list used to be added to rather than replaced
        $this->assertFalse(Input::arrGetsVoid(['a' => '1', 'b' => '2']));
        $this->assertSame([], Input::voidKeys());
    }

    public function test_a_value_that_is_itself_an_array_is_handled(): void
    {
        // request data can hold a "name[]" field, which trim() could not take
        $this->assertTrue(Input::arrGetsVoid(['tags' => [], 'name' => 'foo']));
        $this->assertSame(['tags'], Input::voidKeys());

        $this->assertFalse(Input::arrGetsVoid(['tags' => ['x'], 'name' => 'foo']));
    }
}
