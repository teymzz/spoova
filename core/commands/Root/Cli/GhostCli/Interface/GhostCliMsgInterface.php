<?php

namespace spoova\mi\core\commands\Root\Cli\GhostCli\Interface;

use Closure;

interface GhostCliMsgInterface {
    
    /**
     * Set default error message
     *   - Note: If fatal error message is not defined, this message will be assumed as the default fatal error message.
     * @param string $title
     *   - When set as true, enables default error message display.
     * @param string $message
     * @param integer $indent
     * @param string $color
     * @return void
     */
    function onError(string|bool $title, string $message, int $indent = 0, string $color = 'danger|black') : void;

    /**
     * Sets fatal error message which overrides a default message when an error occurs
     *
     * @param string $title
     * @param string $message
     * @param integer $indent
     * @param string $color
     * @return void
     */
    function onFatal(string $title, string $message, int $indent = 0, string $color = 'danger|black') : void;

    /**
     * Sets custom error message
     *
     * @param string $title
     * @param string $message
     * @param integer $indent
     * @param string $color
     * @return void
     */
    function onNotice(string $title, string $message, int $indent = 0, string $color = 'danger|black') : void;

    /**
     * Sets custom error message
     *
     * @param string $message
     * @param integer $indent
     * @param string $color
     * @return void
     */
    function onInfo(string $message, int $indent = 0, string $color = 'danger|black') : void;

    /**
     * Sets custom error message
     *
     * @param Closure $callback
     * @return void
     */
    function onFinal(Closure $callback, string $type = 'before', bool $exit = false) : void;
}