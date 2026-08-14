<?php

namespace spoova\mi\core\commands\Support\Handlers;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\DB\DBConfig;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliArgs;
use spoova\mi\core\commands\Root\Entry;

/**
 * class Sanitize
 *
 * Handles "php mi project sanitize" — prepares the project for deployment and
 * reports what would break once it leaves a case-insensitive filesystem.
 *
 * Reporting is the default. Nothing is written unless -w is supplied, so the
 * command is safe to run out of habit before every upload.
 *
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class Sanitize extends Entry
{
    /** Longest line the report will print, so it fits an 80 column console. */
    private const width = 76;

    /** Where the originals are kept before anything is overwritten. */
    private const backup = 'backup';

    private SanitizeAudit $audit;

    private bool $write = false;

    /**
     * Leave the database configuration files alone.
     *
     * Credentials are still reported, so the run says what it did not touch rather
     * than quietly passing over it.
     */
    private bool $safe = false;

    public function __construct(array $args = [])
    {
        $input = (new CliArgs($args))
            ->flag('write',   ['-w', '--write'])
            ->flag('restore', ['-r', '--restore'])
            ->flag('safe',    ['-s', '--safe'])
            ->max(0)
            ->parse();

        self::commandTitle('project '.Cli::warn('sanitize'));

        if (!$input->ok()) {
            foreach ($input->errors() as $error) {
                Cli::errorView($error, break: 1);
            }
            $this->usage();
            return;
        }

        $this->audit = new SanitizeAudit();
        $this->write = $input->isFlag('write');
        $this->safe  = $input->isFlag('safe');

        /* Restoring only ever writes a database configuration file, so asking for it
           safely is a contradiction rather than a narrower request. */
        if ($this->safe && $input->isFlag('restore')) {
            Cli::errorView('"-s" cannot be combined with "-r" — restoring only writes database configuration files.', break: 1);
            $this->usage();
            return;
        }

        if ($input->isFlag('restore')) {
            $this->restore();
            return;
        }

        $classes = $this->reportClasses();
        $config  = $this->reportConfig();
        $storage = $this->reportStorage();

        $this->summarise($classes, $config, $storage);
    }

    /* --------------------------------------------------------------------- *
     *  Classes                                                               *
     * --------------------------------------------------------------------- */

    /**
     * Class files the autoloader would miss on a case-sensitive filesystem.
     *
     * Never fixed automatically — renaming a file that other code refers to is
     * the developer's call, and a rename is not always the right correction
     * (the declaration may be what is wrong, not the filename).
     */
    private function reportClasses(): int
    {
        $findings = $this->audit->classFindings();
        $checked  = count($this->audit->files());

        $this->section('classes');

        if (!$findings) {
            $this->pass($checked.' files scanned, no naming faults');
            return 0;
        }

        foreach ($findings as $finding) {
            $arrow = $finding['kind'] === 'case'
                ? basename($finding['actual']).' → '.basename($finding['expected'])
                : $finding['actual'].' → '.$finding['expected'];

            $where = $finding['kind'] === 'case' ? dirname($finding['actual']) : '';

            $this->fail($this->fit(trim($where.'  '.$arrow)));
        }

        $this->note('will load on Windows, not on Linux');

        return count($findings);
    }

    /* --------------------------------------------------------------------- *
     *  Credentials                                                           *
     * --------------------------------------------------------------------- */

    private function reportConfig(): int
    {
        $this->section('config');

        $path = $this->audit->dbconfigPath();

        if (!is_file($path)) {
            $this->pass('icore/dbconfig.php not present');
            return 0;
        }

        if (!DBConfig::load($path, $config)) {
            $this->fail('icore/dbconfig.php  '.(DBConfig::response() ?? 'could not be read'));
            return 1;
        }

        $filled = SanitizeAudit::filledCredentials($config['offline'] ?? []);

        if (!$filled) {
            $this->pass('icore/dbconfig.php  offline credentials already clear');
            return 0;
        }

        $this->fail($this->fit('icore/dbconfig.php  offline: '.implode(', ', $filled)));

        if ($this->safe) {
            $this->note('left untouched by '.Cli::warn('-s').' — clear it before uploading');
            return 1;
        }

        if (!$this->write) {
            return 1;
        }

        if (!$this->backup('icore/dbconfig.php')) {
            return 1;
        }

        $online = $config['online'] ?? [];
        $blank  = array_fill_keys(SanitizeAudit::credentials, '');

        $built = DBConfig::build('icore', $this->ordered($online), $this->ordered($blank));

        if ($built === '' || file_put_contents($path, $built) === false) {
            $this->fail('icore/dbconfig.php  could not be rewritten');
            return 1;
        }

        $this->done('offline credentials cleared');

        return 0;
    }

    /**
     * DBConfig::build() reads its arrays positionally, in the order
     * [NAME, USER, PASS, SERVER, PORT, SOCKET].
     */
    private function ordered(array $config): array
    {
        return [
            (string) ($config['NAME']   ?? ''),
            (string) ($config['USER']   ?? ''),
            (string) ($config['PASS']   ?? ''),
            (string) ($config['SERVER'] ?? ''),
            (string) ($config['PORT']   ?? ''),
            (string) ($config['SOCKET'] ?? ''),
        ];
    }

    /* --------------------------------------------------------------------- *
     *  Storage                                                               *
     * --------------------------------------------------------------------- */

    /**
     * core/storage is regenerated by the application online, so it is upload
     * weight and nothing else. This is the same sweep as "mi clean storage".
     */
    private function reportStorage(): int
    {
        $this->section('storage');

        $usage = $this->audit->storageUsage();

        if ($usage['count'] === 0) {
            $this->pass('core/storage already empty');
            return 0;
        }

        $this->fail('core/storage  '.$usage['count'].' files, '.SanitizeAudit::readableSize($usage['bytes']));

        if (!$this->write) {
            return 1;
        }

        $Filemanager = new Filemanager;
        $Filemanager->deleteFile($this->audit->storagePath(), ['exclude' => $this->audit->storagePath()]);

        $this->done('storage cleared');

        return 0;
    }

    /* --------------------------------------------------------------------- *
     *  Backup and restore                                                    *
     * --------------------------------------------------------------------- */

    /**
     * Copy a project file into backup/ before it is overwritten, keeping its
     * position within the project so more files can join it later.
     */
    private function backup(string $relative): bool
    {
        $source = $this->audit->root().'/'.$relative;
        $target = $this->audit->root().'/'.self::backup.'/'.$relative;

        if (!is_dir($directory = dirname($target)) && !mkdir($directory, 0777, true)) {
            $this->fail('backup/ could not be created — nothing was changed');
            return false;
        }

        if (!copy($source, $target)) {
            $this->fail('backup of '.$relative.' failed — nothing was changed');
            return false;
        }

        $this->done('backed up to '.self::backup.'/'.$relative);

        return true;
    }

    private function restore(): void
    {
        $this->section('restore');

        $restored = 0;

        foreach (['icore/dbconfig.php'] as $relative) {
            $source = $this->audit->root().'/'.self::backup.'/'.$relative;

            if (!is_file($source)) {
                $this->pass('no backup of '.$relative);
                continue;
            }

            if (copy($source, $this->audit->root().'/'.$relative)) {
                $this->done($relative.' restored');
                $restored++;
            } else {
                $this->fail($relative.' could not be restored');
            }
        }

        Cli::break(1);

        if ($restored) {
            Cli::textView(Cli::success($restored.' file(s) restored from '.self::backup.'/'), 1, '|1');
        }
    }

    /* --------------------------------------------------------------------- *
     *  Output                                                                *
     * --------------------------------------------------------------------- */

    private function summarise(int $classes, int $config, int $storage): void
    {
        $total = $classes + $config + $storage;

        Cli::break(1);

        if ($total === 0) {
            Cli::textView(Cli::success('project is clean — safe to upload'), 1, '|1');
            return;
        }

        if ($this->write) {
            /* Anything written successfully reported 0, so what is left here is the
               true remainder — including whatever -s deliberately skipped. Counting
               $classes alone under-reported a write that failed. */
            Cli::textView(Cli::warning($total.' item(s) still need a decision', 1), 1, '|1');
            return;
        }

        // keep -s in the suggested command, or the hint undoes the intent behind it
        $apply = $this->safe ? 'project sanitize -w -s' : 'project sanitize -w';

        Cli::textView(Cli::warn($total.' item(s) found.').' Run'.self::mi($apply, '', '', '').'to apply.', 1, '|1');
        Cli::textView(Cli::alert('backup/').' holds the originals — add it to .gitignore.', 1, '|1');
    }

    private function usage(): void
    {
        Cli::textView('prepares project app for online deployment', 0, 2);
        Cli::textView('Syntax:'.self::mi('project sanitize', '', '', '').Cli::warn('[-w|-r] [-s]'), 0, 1);
        Cli::break(1);
        Cli::textView(Cli::warn('-w').'  apply changes (default is report only)', 2, 1);
        Cli::textView(Cli::warn('-r').'  restore config files from backup/', 2, 1);
        Cli::textView(Cli::warn('-s').'  leave database config files untouched (still reported)', 2, 1);
        Cli::break(1);
    }

    private function section(string $name): void
    {
        Cli::break(1);
        Cli::textView(Cli::danger(strtoupper($name)), 1, 1);
    }

    private function fail(string $line): void
    {
        Cli::textView(Cli::danger(Cli::emo('crossmark')).' '.$line, 2, 1);
    }

    private function pass(string $line): void
    {
        Cli::textView(Cli::valid(Cli::emo('checkmark')).' '.$line, 2, 1);
    }

    private function done(string $line): void
    {
        Cli::textView(Cli::alert('→').' '.$line, 4, 1);
    }

    private function note(string $line): void
    {
        Cli::textView(Cli::warn('· '.$line), 4, 1);
    }

    /**
     * Keep a line inside the console width, dropping characters from the left of
     * a path rather than the right so the filename stays readable.
     */
    private function fit(string $line): string
    {
        if (mb_strlen($line) <= self::width) {
            return $line;
        }

        return '…'.mb_substr($line, -(self::width - 1));
    }
}
