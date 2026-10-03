<?php 

namespace spoova\mi\core\commands\Root\Cli\GhostCli\Interface;

interface GhostCliLockerInterface {

    public function onEmptyArguments(string $message);

    public function onMissingArguments(array|string $args, string $message, string $title);

    public function onBreakArguments(array|string $patterns, string $message, string $title);

    public function onBelowArguments(int $limit, string $message, string $title);

    public function onAboveArguments(int $limit, string $message, string $title);

    public function onTotalArguments(int $count, string $message, string $title);

    public function onFlagArguments(array $options, string $message, string $title);
    
}