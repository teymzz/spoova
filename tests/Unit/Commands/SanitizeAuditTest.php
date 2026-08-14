<?php

namespace spoova\mi\tests\Unit\Commands;

use PHPUnit\Framework\TestCase;
use spoova\mi\core\commands\Support\Handlers\SanitizeAudit;

/**
 * Covers SanitizeAudit — the reading half of "project sanitize".
 *
 * The class-naming rules are the reason the command exists, and they are exactly
 * the rules a Windows machine cannot check for itself: is_file() there is
 * case-insensitive and will confirm a file Linux would never find. Everything
 * below therefore works on strings, not on filesystem probes.
 */
class SanitizeAuditTest extends TestCase
{
    /* ---- finding declarations ---- */

    public function test_a_class_is_found_with_its_namespace(): void
    {
        $source = '<?php namespace App\Models; class User {}';

        $this->assertSame(['App\Models\User'], SanitizeAudit::declarations($source));
    }

    public function test_interfaces_traits_and_enums_are_found_too(): void
    {
        $source = '<?php namespace App; interface A {} trait B {} class C {}';

        $this->assertSame(['App\A', 'App\B', 'App\C'], SanitizeAudit::declarations($source));
    }

    public function test_several_declarations_in_one_file_are_all_found(): void
    {
        $source = '<?php namespace App\DB; trait DBQuery {} trait DBSelect {} class DBHandler {}';

        $this->assertSame(
            ['App\DB\DBQuery', 'App\DB\DBSelect', 'App\DB\DBHandler'],
            SanitizeAudit::declarations($source)
        );
    }

    public function test_a_file_without_a_namespace_reports_the_bare_name(): void
    {
        $this->assertSame(['Legacy'], SanitizeAudit::declarations('<?php class Legacy {}'));
    }

    /**
     * The word "class" appears constantly in comments and strings across this
     * project. A regular expression would report every one of them, so the
     * tokenizer is what keeps the command from crying wolf.
     */
    public function test_the_word_class_in_a_comment_or_string_is_not_a_declaration(): void
    {
        $source = <<<'PHP'
        <?php
        namespace App;
        /** This class does things. @see class Ghost */
        // class Commented {}
        class Real {
            public function run(){ return "class Fake {}"; }
        }
        PHP;

        $this->assertSame(['App\Real'], SanitizeAudit::declarations($source));
    }

    public function test_a_class_constant_is_not_a_declaration(): void
    {
        $source = '<?php namespace App; class Real { const X = Other::class; }';

        $this->assertSame(['App\Real'], SanitizeAudit::declarations($source));
    }

    public function test_an_anonymous_class_is_not_a_declaration(): void
    {
        $source = '<?php namespace App; class Real { public function make(){ return new class {}; } }';

        $this->assertSame(['App\Real'], SanitizeAudit::declarations($source));
    }

    /* ---- resolving the PSR-4 path ---- */

    public function test_a_name_resolves_to_the_path_psr4_will_look_for(): void
    {
        $this->assertSame(
            'core/classes/Router.php',
            SanitizeAudit::expectedPath('spoova\mi\core\classes\Router')
        );
    }

    public function test_a_name_outside_the_project_prefix_has_no_expected_path(): void
    {
        $this->assertNull(SanitizeAudit::expectedPath('PHPUnit\Framework\TestCase'));
        $this->assertNull(SanitizeAudit::expectedPath('Legacy'));
    }

    /* ---- the naming rules ---- */

    /**
     * The real case this command was written for: on Windows the autoloader finds
     * FileManager.php when asked for Filemanager.php, and on Linux it does not.
     */
    public function test_a_filename_differing_only_in_case_is_a_finding(): void
    {
        $findings = $this->findingsFor([
            'core/classes/Bundle/Filemanager/FileManager.php' =>
                '<?php namespace spoova\mi\core\classes\Bundle\Filemanager; class Filemanager {}',
        ]);

        $this->assertCount(1, $findings);
        $this->assertSame('case', $findings[0]['kind']);
        $this->assertSame('core/classes/Bundle/Filemanager/Filemanager.php', $findings[0]['expected']);
    }

    public function test_a_correctly_named_class_is_not_a_finding(): void
    {
        $findings = $this->findingsFor([
            'core/classes/Router.php' => '<?php namespace spoova\mi\core\classes; class Router {}',
        ]);

        $this->assertSame([], $findings);
    }

    /**
     * Traits written alongside the class they belong to share its file on purpose.
     * They are never individually autoloadable and never will be, so reporting them
     * would bury the one finding that actually matters.
     */
    public function test_classes_sharing_a_file_on_purpose_are_not_findings(): void
    {
        $findings = $this->findingsFor([
            'core/classes/DB/DBHandler.php' =>
                '<?php namespace spoova\mi\core\classes\DB; trait DBQuery {} trait DBSelect {} class DBHandler {}',
        ]);

        $this->assertSame([], $findings);
    }

    /**
     * A class in its own correctly named file, but under a directory its namespace
     * does not describe, fails to autoload everywhere — not only on Linux.
     */
    public function test_a_file_in_the_wrong_directory_is_a_finding(): void
    {
        $findings = $this->findingsFor([
            'core/classes/Bundle/Json/Json.php' => '<?php namespace spoova\mi\core\classes\Json; class Json {}',
        ]);

        $this->assertCount(1, $findings);
        $this->assertSame('path', $findings[0]['kind']);
        $this->assertSame('core/classes/Json/Json.php', $findings[0]['expected']);
    }

    public function test_a_class_outside_the_project_prefix_is_ignored(): void
    {
        $findings = $this->findingsFor([
            'core/classes/Helper.php' => '<?php namespace Vendor\Other; class Anything {}',
        ]);

        $this->assertSame([], $findings);
    }

    /* ---- credentials ---- */

    public function test_offline_credentials_that_are_set_are_reported_by_key(): void
    {
        $filled = SanitizeAudit::filledCredentials([
            'NAME' => 'teymzz', 'USER' => 'root', 'PASS' => '',
            'SERVER' => 'localhost', 'PORT' => '3306', 'SOCKET' => '',
        ]);

        $this->assertSame(['NAME', 'USER', 'SERVER', 'PORT'], $filled);
    }

    /**
     * A sanitize report is the kind of output that gets pasted into a chat, so the
     * values themselves must never appear — only which keys still hold one.
     */
    public function test_the_credential_values_are_never_returned(): void
    {
        $filled = SanitizeAudit::filledCredentials(['PASS' => 'hunter2', 'USER' => 'root']);

        $this->assertSame(['USER', 'PASS'], $filled);
        $this->assertNotContains('hunter2', $filled);
    }

    public function test_a_cleared_config_reports_nothing(): void
    {
        $this->assertSame([], SanitizeAudit::filledCredentials(
            array_fill_keys(SanitizeAudit::credentials, '')
        ));
    }

    public function test_whitespace_is_not_a_credential(): void
    {
        $this->assertSame([], SanitizeAudit::filledCredentials(['USER' => '   ']));
    }

    public function test_a_missing_key_is_not_a_credential(): void
    {
        $this->assertSame(['USER'], SanitizeAudit::filledCredentials(['USER' => 'root']));
    }

    /* ---- sizes ---- */

    public function test_a_size_is_reported_in_the_largest_unit_that_keeps_it_short(): void
    {
        $this->assertSame('0B', SanitizeAudit::readableSize(0));
        $this->assertSame('512B', SanitizeAudit::readableSize(512));
        $this->assertSame('1.0KB', SanitizeAudit::readableSize(1024));
        $this->assertSame('410.2KB', SanitizeAudit::readableSize(420000));
        $this->assertSame('2.5MB', SanitizeAudit::readableSize(2621440));
        $this->assertSame('1.0GB', SanitizeAudit::readableSize(1073741824));
    }

    /* ---- helpers ---- */

    /**
     * Build a throwaway project tree from [relative path => source] and audit it.
     *
     * @param array<string,string> $tree
     * @return list<array{fqcn:string,actual:string,expected:string,kind:string}>
     */
    private function findingsFor(array $tree): array
    {
        $root = sys_get_temp_dir().'/spoova-audit-'.uniqid();

        foreach ($tree as $relative => $source) {
            $path = $root.'/'.$relative;
            if (!is_dir($directory = dirname($path))) {
                mkdir($directory, 0777, true);
            }
            file_put_contents($path, $source);
        }

        $findings = (new SanitizeAudit($root))->classFindings();

        $this->removeTree($root);

        return $findings;
    }

    private function removeTree(string $path): void
    {
        if (!is_dir($path)) {
            return;
        }

        foreach (scandir($path) as $entry) {
            if ($entry === '.' || $entry === '..') continue;
            $child = $path.'/'.$entry;
            is_dir($child) ? $this->removeTree($child) : unlink($child);
        }

        rmdir($path);
    }
}
