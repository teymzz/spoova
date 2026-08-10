<?php

namespace spoova\mi\tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use spoova\mi\core\classes\Collection;
use spoova\mi\core\classes\Record;

/**
 * Covers Collection — the iterable list a model hands back — and Record, the
 * single row inside it.
 */
class CollectionTest extends TestCase
{
    /** Two rows, in the shape a model would produce. */
    private function rows(): Collection
    {
        return Collection::list([
            ['id' => 1, 'name' => 'joe', 'email' => 'joe@example.com'],
            ['id' => 2, 'name' => 'ann', 'email' => 'ann@example.com'],
        ]);
    }

    /* ---- shape ---- */

    public function test_each_row_becomes_a_record(): void
    {
        $collection = $this->rows();

        $this->assertCount(2, $collection->data());
        $this->assertContainsOnlyInstancesOf(Record::class, $collection->data());
    }

    /**
     * A list of scalars is not a list of rows, but it still has to iterate — each
     * value is wrapped as a single-column record rather than being dropped.
     */
    public function test_a_list_of_scalars_is_wrapped_one_value_to_a_record(): void
    {
        $collection = Collection::list(['a', 'b']);

        $values = [];
        foreach ($collection as $record) {
            $values[] = $record->data();
        }

        $this->assertSame([['a'], ['b']], $values);
    }

    public function test_an_empty_list_is_a_collection_with_nothing_in_it(): void
    {
        $collection = Collection::list([]);

        $this->assertSame([], $collection->data());
        $this->assertSame(0, iterator_count($collection));
    }

    /* ---- iterating ---- */

    public function test_iterating_walks_every_row_in_order(): void
    {
        $names = [];
        foreach ($this->rows() as $record) {
            $names[] = $record->name;
        }

        $this->assertSame(['joe', 'ann'], $names);
    }

    /**
     * The iterator counts positions rather than reading the array's own keys, so a
     * second loop over the same instance has to start from the top again.
     */
    public function test_a_collection_can_be_walked_more_than_once(): void
    {
        $collection = $this->rows();

        $first = [];
        foreach ($collection as $record) {
            $first[] = $record->id;
        }

        $second = [];
        foreach ($collection as $record) {
            $second[] = $record->id;
        }

        $this->assertSame($first, $second);
    }

    public function test_the_loop_key_is_the_row_position(): void
    {
        $keys = [];
        foreach ($this->rows() as $key => $record) {
            $keys[] = $key;
        }

        $this->assertSame([0, 1], $keys);
    }

    /* ---- reading a row ---- */

    public function test_a_named_column_is_read_off_a_row(): void
    {
        $this->assertSame('joe', $this->rows()->get(0, 'name'));
    }

    public function test_a_list_of_columns_comes_back_keyed_by_column(): void
    {
        $this->assertSame(
            ['id' => 1, 'name' => 'joe'],
            $this->rows()->get(0, ['id', 'name'])
        );
    }

    /**
     * A row that is not there is reported, not fabricated — every column of the
     * requested list still has to be present in the result so the caller can index it.
     */
    public function test_a_missing_row_reports_false_for_every_column_asked_for(): void
    {
        $collection = $this->rows();

        $this->assertFalse($collection->get(99, 'name'));
        $this->assertSame(['id' => false, 'name' => false], $collection->get(99, ['id', 'name']));
    }

    /**
     * The return type used to omit Record, so fetching a whole row — the documented
     * behaviour when no column is named — raised a TypeError on the way out.
     */
    public function test_a_whole_row_can_be_fetched_without_naming_a_column(): void
    {
        $collection = $this->rows();

        $this->assertInstanceOf(Record::class, $collection->get(0));
        $this->assertSame('joe', $collection->get(0)->name);
        $this->assertFalse($collection->get(99));
    }

    public function test_data_reaches_a_row_by_position(): void
    {
        $collection = $this->rows();

        $this->assertInstanceOf(Record::class, $collection->data(0));
        $this->assertSame('ann', $collection->data(1)->name);
    }

    /* ---- protected columns ---- */

    public function test_protected_column_names_are_collected(): void
    {
        $collection = $this->rows();

        $collection->protect(['email'])->protect(['name']);

        $this->assertSame(['email', 'name'], $collection->protected());
    }

    public function test_protect_is_chainable(): void
    {
        $collection = $this->rows();

        $this->assertSame($collection, $collection->protect(['email']));
    }

    public function test_a_column_can_be_unprotected_again(): void
    {
        $collection = $this->rows();
        $collection->protect(['email', 'name']);

        $collection->unprotected(['email']);

        $this->assertSame(['name'], array_values($collection->protected()));
    }

    public function test_unprotecting_a_column_that_was_never_protected_changes_nothing(): void
    {
        $collection = $this->rows();
        $collection->protect(['email']);

        $collection->unprotected(['id']);

        $this->assertSame(['email'], array_values($collection->protected()));
    }

    /* ---- error message ---- */

    /**
     * error() is both the setter and the getter, so the argument count is the only
     * thing separating them — clearing the message must not be read as a read.
     */
    public function test_the_error_message_is_set_and_read_through_one_method(): void
    {
        $collection = $this->rows();

        $this->assertFalse($collection->error());

        $collection->error('no rows matched');
        $this->assertSame('no rows matched', $collection->error());

        $collection->error(false);
        $this->assertFalse($collection->error());
    }

    /* ---- a single record ---- */

    public function test_a_record_exposes_its_columns_as_properties_and_as_an_array(): void
    {
        $record = new Record(['id' => 1, 'name' => 'joe']);

        $this->assertSame(1, $record->id);
        $this->assertSame('joe', $record->data('name'));
        $this->assertSame(['id' => 1, 'name' => 'joe'], $record->data());
    }

    /**
     * The property read used to return the same thing from both sides of its own
     * guard, so an unknown column raised an undefined-key warning on its way to NULL.
     * A column that is not there is reported the way data() reports it.
     */
    public function test_a_column_a_record_does_not_have_reports_false(): void
    {
        $record = new Record(['id' => 1]);

        $this->assertFalse($record->data('missing'));
        $this->assertFalse($record->missing);
    }

    /**
     * Without __isset(), isset() and ?? answer for the undeclared property rather
     * than for the column, which reports every column of every record as absent.
     */
    public function test_a_record_answers_isset_for_its_columns(): void
    {
        $record = new Record(['id' => 1, 'name' => 'joe']);

        $this->assertTrue(isset($record->name));
        $this->assertFalse(isset($record->missing));
        $this->assertSame('joe', $record->name ?? 'fallback');
        $this->assertSame('fallback', $record->missing ?? 'fallback');
    }

    public function test_reading_an_unknown_column_raises_nothing(): void
    {
        $record = new Record(['id' => 1]);

        $raised = [];
        set_error_handler(function (int $type, string $message) use (&$raised) {
            $raised[] = $message;
            return true;
        });

        try {
            $record->missing;
            $record->data('missing');
        } finally {
            restore_error_handler();
        }

        $this->assertSame([], $raised);
    }

    /**
     * The list used to be pushed as a nested array, so it never matched a column
     * name and every read of it came back empty.
     */
    public function test_a_record_reports_which_columns_it_masks(): void
    {
        $record = new Record(['id' => 1, 'password' => 'secret', 'token' => 'abc']);

        $record->protect('password')->protect(['token']);

        $this->assertSame(['password', 'token'], $record->protected());
    }

    /**
     * Protection is what keeps a password hash out of a response body, so the masked
     * value has to be what every ordinary read returns — not just the array form.
     */
    public function test_a_protected_column_reads_as_masked(): void
    {
        $record = new Record(['id' => 1, 'password' => 'secret']);

        $record->protect('password');

        $this->assertSame('**protected**', $record->password);
        $this->assertSame('**protected**', $record->data('password'));
        $this->assertSame(['id' => 1, 'password' => '**protected**'], $record->data());
    }

    public function test_protecting_one_column_leaves_the_others_readable(): void
    {
        $record = new Record(['id' => 1, 'password' => 'secret']);
        $record->protect('password');

        $this->assertSame(1, $record->id);
    }

    public function test_several_columns_can_be_protected_at_once(): void
    {
        $record = new Record(['id' => 1, 'password' => 'secret', 'token' => 'abc']);

        $record->protect(['password', 'token']);

        $this->assertSame('**protected**', $record->data('password'));
        $this->assertSame('**protected**', $record->data('token'));
        $this->assertSame(1, $record->data('id'));
    }

    public function test_protect_is_chainable_on_a_record(): void
    {
        $record = new Record(['password' => 'secret']);

        $this->assertSame($record, $record->protect('password'));
    }
}
