<?php

namespace spoova\mi\tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

class FilemanagerEnvTest extends TestCase
{
    public function test_file_parsing_applies_value_options_without_changing_keys(): void
    {
        $values = Filemanager::parse([
            'quoted' => "'value'",
            'commented' => 'value # comment',
            'spaced' => '  My value  ',
        ], [
            'strip_inline_comments' => 'TrUe',
            'strip_quotes' => 'TRUE',
            'strip_spaces' => 'normal',
        ]);

        $this->assertSame([
            'quoted' => 'value',
            'commented' => 'value',
            'spaced' => 'My value',
        ], $values);
    }

    public function test_loadenv_strips_quotes_and_inline_comments_by_default(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'spoova-env-');
        file_put_contents($path, "QUOTED='value'\nCOMMENTED=value # comment\n");

        try {
            $values = Filemanager::loadenv($path);

            $this->assertSame('value', $values['QUOTED']);
            $this->assertSame('value', $values['COMMENTED']);
        } finally {
            unlink($path);
        }
    }
}