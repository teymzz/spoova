<?php

namespace spoova\mi\tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use spoova\mi\core\classes\ErrorLogger;

/**
 * Covers ErrorLogger, which records errors to a file so they need not be shown
 * on the page.
 */
class ErrorLoggerTest extends TestCase
{
    private string $dir;

    protected function setUp(): void
    {
        $this->dir = 'logs-test-'.uniqid();

        ErrorLogger::$logDir  = $this->dir;
        ErrorLogger::$enabled = true;
        ErrorLogger::$display = null;
        ErrorLogger::$maxBytes = 5242880;
        // never let a test append to the real project's .gitignore
        ErrorLogger::$gitignore = false;
    }

    protected function tearDown(): void
    {
        $directory = ErrorLogger::directory();

        foreach (glob($directory.DIRECTORY_SEPARATOR.'*') ?: [] as $file) {
            @unlink($file);
        }

        @unlink($directory.DIRECTORY_SEPARATOR.'.htaccess');
        @rmdir($directory);

        ErrorLogger::$logDir  = 'logs';
        ErrorLogger::$enabled = null;
        ErrorLogger::$display = null;
        ErrorLogger::$gitignore = true;
    }

    private function contents(): string
    {
        return is_file(ErrorLogger::path())? (string) file_get_contents(ErrorLogger::path()) : '';
    }

    /* ---- switches ---- */

    /**
     * Logging is opt-in. A project that has not asked for it must not silently
     * start writing files.
     */
    public function test_nothing_is_written_while_logging_is_off(): void
    {
        ErrorLogger::$enabled = false;

        $this->assertFalse(ErrorLogger::log(['message' => 'boom', 'file' => 'a.php', 'line' => 1]));
        $this->assertFalse(is_file(ErrorLogger::path()));
    }

    /**
     * Switching logging on must not blank the error pages a developer relies on —
     * hiding them is a separate decision.
     */
    public function test_display_stays_on_by_default(): void
    {
        $this->assertTrue(ErrorLogger::displaying());
    }

    public function test_display_can_be_switched_off_independently(): void
    {
        ErrorLogger::$display = false;

        $this->assertFalse(ErrorLogger::displaying());
        $this->assertTrue(ErrorLogger::enabled(), 'the two switches are independent');
    }

    /* ---- what gets written ---- */

    public function test_an_error_array_is_recorded(): void
    {
        $this->assertTrue(ErrorLogger::log([
            'type'    => E_WARNING,
            'message' => 'something went wrong',
            'file'    => '/app/thing.php',
            'line'    => 42,
        ], 'error'));

        $log = $this->contents();

        $this->assertStringContainsString('E_WARNING', $log);
        $this->assertStringContainsString('something went wrong', $log);
        $this->assertStringContainsString('/app/thing.php:42', $log);
    }

    public function test_a_throwable_is_recorded_with_its_trace(): void
    {
        ErrorLogger::log(new RuntimeException('exploded'), 'exception');

        $log = $this->contents();

        $this->assertStringContainsString('exploded', $log);
        $this->assertStringContainsString('EXCEPTION', $log);
        $this->assertStringContainsString('#0', $log, 'a throwable should bring its trace');
    }

    public function test_entries_accumulate_rather_than_replacing_each_other(): void
    {
        ErrorLogger::log(['message' => 'first', 'file' => 'a.php', 'line' => 1]);
        ErrorLogger::log(['message' => 'second', 'file' => 'b.php', 'line' => 2]);

        $log = $this->contents();

        $this->assertStringContainsString('first', $log);
        $this->assertStringContainsString('second', $log);
    }

    /**
     * A log line has to be traceable back to one request, or a busy log is unusable.
     */
    public function test_an_entry_records_where_it_came_from(): void
    {
        ErrorLogger::log(['message' => 'boom', 'file' => 'a.php', 'line' => 1]);

        // the suite runs on CLI, so the context names the console
        $this->assertStringContainsString('cli', $this->contents());
    }

    public function test_severity_names_the_php_level(): void
    {
        ErrorLogger::log(['type' => E_USER_DEPRECATED, 'message' => 'old', 'file' => 'a.php', 'line' => 1]);

        $this->assertStringContainsString('E_USER_DEPRECATED', $this->contents());
    }

    /* ---- what is ignored ---- */

    public function test_nothing_to_report_is_not_written(): void
    {
        $this->assertFalse(ErrorLogger::log(null));
        $this->assertFalse(ErrorLogger::log([]));
        $this->assertFalse(ErrorLogger::log(['message' => '   ']), 'an empty message is not an error');
        $this->assertFalse(is_file(ErrorLogger::path()));
    }

    public function test_describe_reports_nothing_for_an_empty_error(): void
    {
        $this->assertNull(ErrorLogger::describe([], 'error'));
        $this->assertNull(ErrorLogger::describe(null, 'error'));
    }

    /* ---- the directory ---- */

    /**
     * A log describes the application in detail, so it must not be reachable over
     * the web even if the directory is uploaded by mistake.
     */
    public function test_the_log_directory_denies_web_access(): void
    {
        ErrorLogger::log(['message' => 'boom', 'file' => 'a.php', 'line' => 1]);

        $htaccess = ErrorLogger::directory().DIRECTORY_SEPARATOR.'.htaccess';

        $this->assertFileExists($htaccess);
        $this->assertStringContainsString('Require all denied', (string) file_get_contents($htaccess));
    }

    /**
     * Logs live outside core/storage on purpose: "mi project sanitize" empties that
     * directory, and a log a deploy step deletes is not a log.
     */
    public function test_logs_are_kept_outside_the_disposable_storage_directory(): void
    {
        $this->assertStringNotContainsString(
            'core'.DIRECTORY_SEPARATOR.'storage',
            ErrorLogger::directory()
        );
    }

    /* ---- housekeeping ---- */

    public function test_a_log_is_rolled_aside_once_it_grows_too_large(): void
    {
        ErrorLogger::$maxBytes = 200;

        for ($i = 0; $i < 12; $i++) {
            ErrorLogger::log(['message' => 'entry number '.$i, 'file' => 'a.php', 'line' => $i]);
        }

        $this->assertGreaterThan(1, count(ErrorLogger::files()), 'the log should have been rotated');
    }

    public function test_files_are_listed_newest_first(): void
    {
        ErrorLogger::log(['message' => 'boom', 'file' => 'a.php', 'line' => 1]);

        $files = ErrorLogger::files();

        $this->assertNotEmpty($files);
        $this->assertStringContainsString('error-', basename($files[0]));
    }

    public function test_prune_removes_only_the_old_files(): void
    {
        ErrorLogger::log(['message' => 'boom', 'file' => 'a.php', 'line' => 1]);

        $this->assertSame(0, ErrorLogger::prune(30), 'a fresh log is not old');

        foreach (ErrorLogger::files() as $file) {
            touch($file, time() - (40 * 86400));
        }

        $this->assertSame(1, ErrorLogger::prune(30));
        $this->assertSame([], ErrorLogger::files());
    }
}
