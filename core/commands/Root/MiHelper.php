<?php

namespace spoova\mi\core\commands\Root;

use spoova\mi\core\commands\Root\Cli;

class MiHelper {

    public static function try(string $command, string $spacing = '0|0', string|int|array $break = '0|0'){

        Cli::textPlain('| Try using: [mi] » '.trim($command), spacing: $spacing, break: $break);

    }

    public static function run(string $command, string $spacing = '0|0', string|int|array $break = '0|0'){

        Cli::textPlain(Cli::danger('▪ '.'run :').' [mi] » '.$command, spacing: $spacing, break: $break);

    }

}