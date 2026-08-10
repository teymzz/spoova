<?php

namespace spoova\mi\tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use RuntimeException;
use spoova\mi\core\classes\Benchmark;

/**
 * Covers Benchmark, which times a list of callables and tabulates the results.
 */
class BenchmarkTest extends TestCase
{
    /** Options are static, so they leak between tests unless put back. */
    protected function setUp(): void
    {
        Benchmark::reset();

        $benchmark = new ReflectionClass(Benchmark::class);

        foreach (['repeat' => 1, 'warmup' => false, 'sorted' => false,
                  'base' => [], 'basefile' => '', 'tolerance' => 0.10] as $property => $value) {
            $reflected = $benchmark->getProperty($property);
            $reflected->setAccessible(true);
            $reflected->setValue(null, $value);
        }
    }

    /* ---- measurement ---- */

    /**
     * The start time used to be held in an int property, which floored the clock
     * and inflated every reading by the fraction of a second it discarded — up to
     * a full second, differently on each run.
     */
    public function test_measures_the_actual_elapsed_time(): void
    {
        $results = Benchmark::fn(['sleep' => fn() => usleep(120000)], false);

        $this->assertGreaterThanOrEqual(0.10, $results['sleep']['diff']);
        $this->assertLessThan(0.60, $results['sleep']['diff']);
    }

    /**
     * Durations were formatted to four decimal places before being stored, so
     * anything quicker than 100µs was recorded as zero.
     */
    public function test_a_sub_millisecond_test_does_not_collapse_to_zero(): void
    {
        Benchmark::repeat(50);

        $results = Benchmark::fn(['fast' => fn() => strlen('abc')], false);

        $this->assertGreaterThan(0.0, $results['fast']['diff']);
        $this->assertStringNotContainsString('0ms', $results['fast']['time']);
    }

    public function test_picks_a_unit_that_keeps_the_reading_readable(): void
    {
        $results = Benchmark::fn([
            'quick' => fn() => strlen('abc'),
            'slow'  => fn() => usleep(30000),
        ], false);

        $this->assertMatchesRegularExpression('/(ns|µs)$/', $results['quick']['time']);
        $this->assertStringEndsWith('ms', $results['slow']['time']);
    }

    public function test_repeat_averages_over_the_runs_and_reports_the_spread(): void
    {
        Benchmark::repeat(25);

        $results = Benchmark::fn(['work' => fn() => str_repeat('x', 100)], false);

        $this->assertSame(25, $results['work']['runs']);
        $this->assertLessThanOrEqual($results['work']['diff'], $results['work']['min']);
        $this->assertGreaterThanOrEqual($results['work']['diff'], $results['work']['max']);
        $this->assertEqualsWithDelta($results['work']['total'] / 25, $results['work']['diff'], 1e-9);
    }

    /* ---- failing tests ---- */

    public function test_a_throwing_test_is_recorded_and_does_not_stop_the_rest(): void
    {
        $results = Benchmark::fn([
            'first'  => fn() => strlen('abc'),
            'broken' => fn() => throw new RuntimeException('boom'),
            'third'  => fn() => strlen('abc'),
        ], false);

        $this->assertStringContainsString('boom', $results['broken']['error']);
        $this->assertSame('', $results['first']['error']);
        $this->assertSame('', $results['third']['error']);
        $this->assertCount(3, $results);
    }

    public function test_a_value_that_cannot_be_called_is_reported_not_skipped(): void
    {
        $results = Benchmark::fn(['bad' => 12345], false);

        $this->assertStringContainsString('not callable', $results['bad']['error']);
        $this->assertSame(0, $results['bad']['runs']);
    }

    /**
     * A test that threw stopped early, so its timing is not a result — it must not
     * be able to present itself as the fastest of the group.
     */
    public function test_a_throwing_test_is_left_out_of_the_comparison(): void
    {
        Benchmark::fn([
            'real'   => fn() => usleep(5000),
            'broken' => fn() => throw new RuntimeException('boom'),
        ], false);

        $table = Benchmark::render(true);

        $this->assertMatchesRegularExpression('/real.*x1\.00/', $table);
        $this->assertDoesNotMatchRegularExpression('/broken.*x1\.00/', $table);
    }

    /* ---- reading the results ---- */

    public function test_info_reads_all_one_or_several_results(): void
    {
        Benchmark::fn(['a' => fn() => strlen('a'), 'b' => fn() => strlen('b')], false);

        $this->assertCount(2, Benchmark::info());
        $this->assertIsArray(Benchmark::info('a'));
        $this->assertFalse(Benchmark::info('missing'));
        $this->assertSame(['a', 'b'], array_keys(Benchmark::info(['a', 'b'])));
        $this->assertFalse(Benchmark::info(['a', 'missing'])['missing']);
    }

    public function test_reset_clears_the_results(): void
    {
        Benchmark::fn(['a' => fn() => strlen('a')], false);
        Benchmark::reset();

        $this->assertSame([], Benchmark::info());
    }

    /* ---- the table ---- */

    /**
     * The name column was sized by the last name seen rather than the longest, so
     * a long name following a short one was clipped.
     */
    public function test_a_long_name_is_not_clipped_by_a_short_one(): void
    {
        Benchmark::fn([
            'aVeryLongBenchmarkNameIndeed' => fn() => strlen('a'),
            'ab' => fn() => strlen('b'),
        ], false);

        $table = Benchmark::render(true);

        $this->assertStringContainsString('aVeryLongBenchmarkNameIndeed', $table);
    }

    public function test_every_row_of_the_table_is_the_same_width(): void
    {
        Benchmark::fn([
            'short' => fn() => strlen('a'),
            'a much longer name' => fn() => strlen('b'),
        ], false);

        $lines = array_filter(explode("\n", trim(Benchmark::render(true))), 'strlen');
        $widths = array_unique(array_map(fn($line) => mb_strlen(rtrim($line, "\r")), $lines));

        $this->assertCount(1, $widths, 'separator and rows disagree on width');
    }

    /* ---- baseline ---- */

    public function test_baseline_records_first_then_compares(): void
    {
        $file = sys_get_temp_dir().'/spoova-bench-'.uniqid().'.json';

        Benchmark::baseline($file);
        Benchmark::fn(['job' => fn() => usleep(2000)], false);

        $this->assertFileExists($file);
        $this->assertStringNotContainsString('Base', Benchmark::render(true));

        Benchmark::reset();
        Benchmark::baseline($file);
        Benchmark::fn(['job' => fn() => usleep(2000)], false);

        $this->assertStringContainsString('Base', Benchmark::render(true));

        unlink($file);
    }

    /* ---- export ---- */

    public function test_exports_json_and_csv(): void
    {
        Benchmark::fn(['job' => fn() => strlen('a')], false);

        $json = sys_get_temp_dir().'/spoova-bench-'.uniqid().'.json';
        $csv  = sys_get_temp_dir().'/spoova-bench-'.uniqid().'.csv';

        $this->assertTrue(Benchmark::export($json));
        $this->assertTrue(Benchmark::export($csv));

        $decoded = json_decode((string) file_get_contents($json), true);
        $this->assertArrayHasKey('job', $decoded);

        $rows = array_filter(explode("\n", trim((string) file_get_contents($csv))), 'strlen');
        $this->assertStringStartsWith('name,runs,diff', $rows[0]);
        $this->assertCount(2, $rows);

        unlink($json);
        unlink($csv);
    }
}
