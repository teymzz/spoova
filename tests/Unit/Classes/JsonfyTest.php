<?php

namespace spoova\mi\tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use spoova\mi\core\classes\Jsonfy;

/**
 * Covers Jsonfy, a small editor for a two-dimensional array that can be loaded
 * from — and handed back as — a JSON string.
 */
class JsonfyTest extends TestCase
{
    private Jsonfy $jsonfy;

    protected function setUp(): void
    {
        $this->jsonfy = new Jsonfy();
    }

    /* ---- loading ---- */

    public function test_a_json_string_is_decoded(): void
    {
        $this->jsonfy->newData('{"a":1,"b":{"c":2}}');

        $this->assertSame(['a' => 1, 'b' => ['c' => 2]], $this->jsonfy->data());
    }

    public function test_an_array_is_taken_as_it_stands(): void
    {
        $this->jsonfy->newData(['a' => 1]);

        $this->assertSame(['a' => 1], $this->jsonfy->data());
    }

    /**
     * The data is typed as an array everywhere else, so anything that does not
     * decode to one has to arrive as an empty array rather than as NULL or a scalar.
     */
    public function test_a_string_that_is_not_json_loads_as_an_empty_array(): void
    {
        $this->jsonfy->newData('not json at all');

        $this->assertSame([], $this->jsonfy->data());
    }

    public function test_json_that_decodes_to_a_scalar_loads_as_an_empty_array(): void
    {
        $this->jsonfy->newData('42');

        $this->assertSame([], $this->jsonfy->data());
    }

    /* ---- reading ---- */

    public function test_data_reports_the_count_and_the_json_form(): void
    {
        $this->jsonfy->newData(['a' => 1, 'b' => 2]);

        $this->assertSame(2, $this->jsonfy->data('count'));
        $this->assertSame('{"a":1,"b":2}', $this->jsonfy->data('json'));
    }

    /**
     * The source is the copy taken at load time; edits must not reach back into it,
     * or there is no before-and-after to compare against.
     */
    public function test_the_source_copy_survives_later_edits(): void
    {
        $this->jsonfy->newData(['a' => 1]);
        $this->jsonfy->add('b', 2);
        $this->jsonfy->delete('a');

        $this->assertSame(['a' => 1], $this->jsonfy->data('source'));
        $this->assertSame(['b' => 2], $this->jsonfy->data());
    }

    public function test_read_returns_the_value_or_false(): void
    {
        $this->jsonfy->newData(['a' => 1]);

        $this->assertSame(1, $this->jsonfy->read('a'));
        $this->assertFalse($this->jsonfy->read('missing'));
    }

    public function test_datakey_finds_the_key_holding_a_value(): void
    {
        $this->jsonfy->newData(['x' => 'foo', 'y' => 'bar']);

        $this->assertSame('y', $this->jsonfy->datakey('bar'));
        $this->assertFalse($this->jsonfy->datakey('nothing'));
    }

    /**
     * A key of 0 is a real key, but it is also falsey — a caller testing the result
     * has to be able to tell it apart from the FALSE that means "not found".
     */
    public function test_a_value_at_the_first_position_is_not_reported_as_missing(): void
    {
        $this->jsonfy->newData(['foo', 'bar']);

        $this->assertSame(0, $this->jsonfy->datakey('foo'));
        $this->assertNotFalse($this->jsonfy->datakey('foo'));
    }

    /* ---- adding ---- */

    public function test_a_single_argument_is_appended_under_a_numbered_key(): void
    {
        $this->jsonfy->newData([]);
        $this->jsonfy->add('first');
        $this->jsonfy->add('second');

        $this->assertSame(['first', 'second'], $this->jsonfy->data());
    }

    public function test_two_arguments_add_a_named_value(): void
    {
        $this->jsonfy->newData([]);
        $this->jsonfy->add('name', 'joe');

        $this->assertSame(['name' => 'joe'], $this->jsonfy->data());
    }

    /**
     * add() is not a setter — an existing key keeps its value, which is what stops
     * a second add() from quietly overwriting data that update() is meant to change.
     */
    public function test_adding_an_existing_key_leaves_it_alone(): void
    {
        $this->jsonfy->newData(['name' => 'joe']);
        $this->jsonfy->add('name', 'ann');

        $this->assertSame('joe', $this->jsonfy->read('name'));
    }

    public function test_three_arguments_add_a_nested_value(): void
    {
        $this->jsonfy->newData([]);
        $this->jsonfy->add('user', 'name', 'joe');

        $this->assertSame(['user' => ['name' => 'joe']], $this->jsonfy->data());
    }

    public function test_an_empty_name_numbers_the_nested_entry(): void
    {
        $this->jsonfy->newData([]);
        $this->jsonfy->add('', 'name', 'joe');

        $this->assertSame([['name' => 'joe']], $this->jsonfy->data());
    }

    /* ---- updating ---- */

    public function test_update_replaces_an_existing_value(): void
    {
        $this->jsonfy->newData(['name' => 'joe']);
        $this->jsonfy->update('name', 'ann');

        $this->assertSame('ann', $this->jsonfy->read('name'));
    }

    /**
     * Unlike add(), update() only edits — a key that is not there must not be
     * created, or a typo in a key name silently grows the structure.
     */
    public function test_update_does_not_create_a_missing_key(): void
    {
        $this->jsonfy->newData(['name' => 'joe']);
        $this->jsonfy->update('missing', 'value');

        $this->assertSame(['name' => 'joe'], $this->jsonfy->data());
    }

    public function test_update_reaches_the_second_level(): void
    {
        $this->jsonfy->newData(['user' => ['name' => 'joe']]);
        $this->jsonfy->update('user', 'name', 'ann');

        $this->assertSame(['user' => ['name' => 'ann']], $this->jsonfy->data());
    }

    public function test_an_empty_key_is_rejected(): void
    {
        $this->jsonfy->newData(['name' => 'joe']);

        $this->assertFalse($this->jsonfy->update('', 'value'));
        $this->assertSame(['name' => 'joe'], $this->jsonfy->data());
    }

    /**
     * Array keys are meaningless here and would be cast to a string by PHP, giving
     * a key nobody asked for — the call is refused instead.
     */
    public function test_an_array_where_a_key_belongs_is_rejected(): void
    {
        $this->jsonfy->newData(['name' => 'joe']);

        $this->assertFalse($this->jsonfy->update(['a'], 'value'));
        $this->assertFalse($this->jsonfy->update(['a'], 'name', 'value'));
        $this->assertSame(['name' => 'joe'], $this->jsonfy->data());
    }

    /* ---- deleting ---- */

    public function test_delete_removes_a_key(): void
    {
        $this->jsonfy->newData(['a' => 1, 'b' => 2]);
        $this->jsonfy->delete('a');

        $this->assertSame(['b' => 2], $this->jsonfy->data());
    }

    public function test_delete_removes_a_nested_key(): void
    {
        $this->jsonfy->newData(['user' => ['name' => 'joe', 'age' => 30]]);
        $this->jsonfy->delete('user', 'age');

        $this->assertSame(['user' => ['name' => 'joe']], $this->jsonfy->data());
    }

    public function test_deleting_something_that_is_not_there_changes_nothing(): void
    {
        $this->jsonfy->newData(['a' => 1, 'user' => ['name' => 'joe']]);
        $this->jsonfy->delete('missing');
        $this->jsonfy->delete('missing', 'sub');
        $this->jsonfy->delete('user', 'missing');

        $this->assertSame(['a' => 1, 'user' => ['name' => 'joe']], $this->jsonfy->data());
    }

    /**
     * A key that holds no sub-keys has nothing to delete, the same as an entirely
     * unknown key. unset($data[$key][$sub]) used to be reached on the scalar anyway,
     * raising a fatal Error rather than doing nothing.
     */
    public function test_deleting_a_sub_key_of_a_scalar_changes_nothing(): void
    {
        $this->jsonfy->newData(['a' => 1, 'b' => 'text']);

        $this->jsonfy->delete('a', 'sub');
        $this->jsonfy->delete('b', 0);

        $this->assertSame(['a' => 1, 'b' => 'text'], $this->jsonfy->data());
    }

    /* ---- round trip ---- */

    public function test_edited_data_survives_a_round_trip_through_json(): void
    {
        $this->jsonfy->newData('{"a":1}');
        $this->jsonfy->add('b', 'two');
        $this->jsonfy->add('c', 'sub', 'three');

        $reloaded = new Jsonfy();
        $reloaded->newData($this->jsonfy->data('json'));

        $this->assertSame($this->jsonfy->data(), $reloaded->data());
    }
}
