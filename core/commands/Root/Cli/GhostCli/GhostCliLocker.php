<?php

namespace spoova\mi\core\commands\Root\Cli\GhostCli;

use Closure;
use spoova\mi\core\classes\Ghost\GhostClass;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\GhostCli\GhostCliPolicyBreaker;

abstract class GhostCliLocker extends GhostClass {

    private const default_message = 'Invalid arguments supplied';
    private const default_title = ' Error ';

    /** @var array default message when an argument validation fails  */
    private array $argumentsEvent = [];

    /**
     * Applies validation logic where the terminal exits if no argument is detected
     *
     * @param string $message
     * @param string $title
     * @return void
     */
    function onEmptyArguments(string $message, $title = ' Error '){
        if(!$this->proxy->args()){
            self::logArgumentsError($title, $message);
            exit;
        }
    }

    /**
     * Applies validation logic where the terminal exits if expected arguments are missing
     *   - This does not check arguments order
     * @param array|string $args
     * @param string $message
     * @param string $title
     * @return void
     */
    function onMissingArguments(array|string $args, string $message, $title = ' Error '){
        $cliArgs = $this->proxy->args();
        if(is_string($args)) $args = [$args];
        if(array_diff($args, $cliArgs)){
            self::logArgumentsError($title, $message);
            exit;
        }
    }

    private static function matchPatternDetailed(string $pattern, array $cliArgs): array
    {
        $tokens = preg_split('/\s+/', trim($pattern));
        $placeholder = null;
        $literalTokens = $tokens;

        $lastIndex = count($tokens) - 1;
        if ($lastIndex >= 0 && preg_match('/^\{(\w+)(\?|\.\.\.|:(\d+))?\}$/', $tokens[$lastIndex], $m)) {
            $placeholder = ['modifier' => $m[2] ?? '', 'count' => isset($m[3]) ? (int) $m[3] : null];
            array_pop($literalTokens);
        }

        $literalCount = count($literalTokens);
        $matchedPrefixLen = 0;

        for ($i = 0; $i < $literalCount; $i++) {
            if (!isset($cliArgs[$i]) || $cliArgs[$i] !== $literalTokens[$i]) {
                return ['prefixMatched' => false, 'fullyMatched' => false, 'prefixLength' => $matchedPrefixLen];
            }
            $matchedPrefixLen++;
        }

        $trailingCount = count(array_slice($cliArgs, $literalCount));

        $fullyMatched = $placeholder === null
            ? $trailingCount === 0
            : match ($placeholder['modifier']) {
                ''      => $trailingCount === 1,
                '?'     => $trailingCount <= 1,
                '...'   => true,
                default => $trailingCount === $placeholder['count'],
            };

        return ['prefixMatched' => true, 'fullyMatched' => $fullyMatched, 'prefixLength' => $literalCount];
    }

    private static function assertNoAmbiguousFormats(array $patterns): void
    {
        $seen = [];

        foreach ($patterns as $key => $pattern) {
            $tokens = preg_split('/\s+/', trim($pattern));
            $lastIndex = count($tokens) - 1;
            $literalTokens = $tokens;

            if ($lastIndex >= 0 && preg_match('/^\{(\w+)(\?|\.\.\.|:(\d+))?\}$/', $tokens[$lastIndex])) {
                array_pop($literalTokens);
            }

            $signature = implode(' ', $literalTokens);

            if (isset($seen[$signature]) && $seen[$signature]['pattern'] !== $pattern) {
                throw new \ErrorException(
                    "Ambiguous formats: key \"{$seen[$signature]['key']}\" (\"{$seen[$signature]['pattern']}\") ".
                    "and key \"$key\" (\"$pattern\") share prefix \"$signature\" with conflicting trailing rules"
                );
            }

            $seen[$signature] = ['key' => $key, 'pattern' => $pattern];
        }
    }

    public function onBreakArguments(string|array $patterns, string|Closure $message = self::default_message, string $title = self::default_title): void
    {
        $patterns = (array) $patterns;
        $cliArgs  = $this->proxy->args();

        $defaults = ['title'=>self::default_title, 'message'=>self::default_message];

        self::assertNoAmbiguousFormats($patterns);

        $keys = array_keys($patterns);
        $failedKey = null;
        $bestPrefixLen = -1;

        foreach ($patterns as $key => $pattern) {
            $result = self::matchPatternDetailed($pattern, $cliArgs);

            if ($result['fullyMatched']) {
                return; // valid — nothing broke
            }

            // Track the closest attempted pattern, not the last one iterated.
            if ($result['prefixLength'] > $bestPrefixLen) {
                $bestPrefixLen = $result['prefixLength'];
                $failedKey = $key;
            }
        }

        if (is_closure($message)) {
            $Ghost = new GhostFunction(['keys', 'failedKey']);
            $Ghost->keys(fn() => $keys);
            $Ghost->failedKey(fn() => $failedKey);

            /** @var GhostCliPolicyBreaker $policyBreaker */
            $policyBreaker = GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends GhostCliPolicyBreaker{});
            $message($policyBreaker);
            $response = $policyBreaker->response();

            $title   = $response['title'] ?? $defaults['title'];
            $message = $response['message'] ?? $defaults['message'];
        }

        self::logArgumentsError($title, $message);
        exit;
    }

    
    
    /**
     * Applies validation logic where the terminal exits if a defined minimum number of arguments are not met
     *
     * @param integer $limit
     * @param string $message
     * @param string $title
     * @return void
     */
    function onBelowArguments(int $limit, string $message, $title = ' Error '){
        $cliArgs = $this->proxy->args();
        if(count($cliArgs) < $limit){
            self::logArgumentsError($title, $message);
            exit;
        }
    }

    /**
     * Applies validation logic where the terminal exits if a defined maximum number of argument is exceeded
     *
     * @param integer $limit
     * @param string $message
     * @param string $title
     * @return void
     */
    function onAboveArguments(int $limit, string $message, $title = ' Error '){
        $cliArgs = $this->proxy->args();
        if(count($cliArgs) > $limit){
            self::logArgumentsError($title, $message);
            exit;
        }
    }

    /**
     * Applies validation logic where the terminal exits if a defined exact total number of arguments is not satisfied
     *
     * @param integer[] $count
     * @param string $message
     * @param string $title
     * @return void
     */
    function onTotalArguments(int|array $count, string $message, $title = ' Error '){
        $cliArgs = $this->proxy->args();
        if(is_int($count)) $count = [$count];

        if(in_array(count($cliArgs), $count)){
            self::logArgumentsError($title, $message);
            exit;
        }
    }

    /**
     * Applies validation logic where the terminal exits certain argument validation events are not met
     *
     * @param array $options optional [breach|above|below|total|break|missing|empty]
     * @param string $message
     * @param string $title
     * @return void
     */
    function onFlagArguments(array $options, string $message, string $title = ' Error '){
        // above, below, break[], missing[], empty
        $valids = ['breach','above','below','break','missing','empty'];
        foreach($options as $key => $option){
            if(in_array($key, $valids)){
                $key = ucfirst($key);
                $key = "on{$key}Arguments";
                if($key === 'onEmptyArguments'){
                    $this->$key($message, $title);
                }else{
                    if(is_array($option)){
                        $opt = array_values($option);
                        if(isset($opt[0])) $option = $opt[0];
                        if(isset($opt[1])) $message = $opt[1];
                        if(isset($opt[2])) $title = $opt[2];
                    }
                    $this->$key($option, $message, $title);
                }
            }
        }
    }

    public function ghostInit() : void {
         $this->argumentsEvent = [];
    }

    private static function logArgumentsError(string $title, string $message) {
            if($title) $data['title'] = $title;
            $data['break'] = 1;
            $data['message'] = $message;
            $title? Cli::infoView(...$data) : Cli::textPlain(...$data); 
    }

}