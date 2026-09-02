<?php

namespace spoova\mi\core\commands\Root\Cli;

use Closure;

class CliDev {

    /**
     * Returns true if CLI terminal controller is Termux
     *
     * @return boolean
     */
    public static function isTermux() : bool {

        return strpos(getenv('SHELL'), 'com.termux');

    }

    /**
     * Returns true if CLI terminal controller is git bash executed through Termux
     *
     * @return boolean
     */
    public static function isTermuxBash() : bool {

        return self::isTermux() && self::isBash();

    }
/**
     * Check php terminal type
     * 
     * @param string[] $type optional [cmd|powershell|wsl|windows|bash|git-bash|termux|termux-bash|linux]
     *  - cmd (or prompt) → windows CMD 
     *  - powershell → windows powershell only
     *  - wsl → WSL terminal only
     *  - wt → Windows Terminal (Terminal Window's wrapper app)
     *  - windows → any windows terminal (WSL, Powershell, CMD)
     *  - bash → git bash, termux or terminals that have bash
     *  - git-bash → git bash
     *  - termux → termux terminals only
     *  - termux-bash → termux, git bash
     *  - linux → linux O.S terminals
     * @return boolean
     */
    static function isTerminal(string|array $type) : bool { 
   
       if(isCli()){
   
           $terminals = (array) $type;
           $terminals = array_map(fn($val) => strtolower($val), $terminals);
           $response = false;
   
           $checkType = function($type){
               if($type === 'wsl') return (stripos(php_uname('r'), 'microsoft') !== false);
               if($type === 'bash') return CliDev::isBash();
               if($type === 'linux') return getOs() === 'linux';
               if($type === 'termux') return CliDev::isTermux();
               if($type === 'termux-bash') return CliDev::isTermuxBash();
               if($type === 'powershell') return (getenv('PSModulePath') !== false);
               if($type === 'git-bash') return in_array(getenv('MSYSTEM'), ['MINGW32','MINGW64']);
               if(str_starts_with($type,'windows') || $type === 'wt') {
                   // WSL, PowerShell, CMD, WT (windows terminal)
                   $NotPSModule = getenv('PSModule') === false;
                   $HasComSpec = stripos(getenv('ComSpec'), 'cmd.exe') !== false;
                   $isMicrosoft = stripos(php_uname('v'), 'Microsoft') !== false;
                   $isWindows = ($NotPSModule && $HasComSpec && $isMicrosoft) ||(getenv('PSModulePath') !== false) || ((stripos(php_uname('r'), 'microsoft') !== false) && isWindows());
                   if($isWindows && in_array($type, ['wt','windows-terminal'])) return (getenv('ANSICON') !== false || getenv('WT_SESSION') !== false);
                   return $isWindows;
               }
               if(in_array($type, ['cmd','command-prompt','prompt'])){
                   $NotPSModule = getenv('PSModule') === false;
                   $HasComSpec = stripos(getenv('ComSpec'), 'cmd.exe') !== false;
                   $isMicrosoft = stripos(php_uname('v'), 'Microsoft') !== false;
                   return $NotPSModule && $HasComSpec && $isMicrosoft;
               } 
           };
   
           foreach($terminals as $terminal){
               $response = $checkType($terminal);
               if($response === true) break;
           }
   
           return (bool) $response;
   
       }
       return false;
    }

    /**
     * Returns true if CLI terminal controller is WSL environment.
     *
     * @return boolean
     */
    public static function isWSL() : bool {

        return self::isTerminal('wsl');

    }


    /**
     * Returns true if CLI terminal console is Bash
     *
     * @return boolean
     */
    public static function isBash() : bool {
        
        return getenv('OSTYPE') === 'msys' || getenv('MSYSTEM') || strpos(getenv('SHELL'), 'bash') !== false;

    }

    /**
     * Check the operating system
     *
     * @param string $os optional [mac|darwin|windows|linux]
     * @return boolean
     */
    public static function isOs(string $os) : bool {
        $devOs = strtolower(PHP_OS_FAMILY);
        $os = $os === 'mac'? 'darwin' : $os;
        return $os === $devOs;
    }

    /**
     * Runs callback for only specified terminals systems
     * 
     * @param string[] $type optional 
     *  - cmd (or prompt) → windows CMD 
     *  - powershell → windows powershell only
     *  - wsl → WSL terminal only
     *  - windows → any windows terminal (WSL, Powershell, CMD)
     *  - bash → git bash, termux or terminals that have bash
     *  - git-bash → git bash
     *  - termux → termux terminals only
     *  - termux-bash → termux, git bash
     *  - linux → linux O.S terminals
     * @param Closure $callback callback to be executed for only specified terminals
     * @return boolean
     */
    public static function for(string|array $type, Closure $callback) : bool {
        
        if(isCli()){

            $terminals = (array) $type;
            $terminals = array_map(fn($val) => strtolower($val), $terminals);
            $response = false;
    
            $checkType = function($type){
                if($type === 'wsl') return (stripos(php_uname('r'), 'microsoft') !== false);
                if($type === 'bash') return CliDev::isBash();
                if($type === 'linux') return getOs() === 'linux';
                if($type === 'termux') return CliDev::isTermux();
                if($type === 'termux-bash') return CliDev::isTermuxBash();
                if($type === 'powershell') return (getenv('PSModulePath') !== false);
                if($type === 'windows') {
                   // WSL, PowerShell, CMD
                   $NotPSModule = getenv('PSModule') === false;
                   $HasComSpec = stripos(getenv('ComSpec'), 'cmd.exe') !== false;
                   $isMicrosoft = stripos(php_uname('v'), 'Microsoft') !== false;
                   return ($NotPSModule && $HasComSpec && $isMicrosoft) ||(getenv('PSModulePath') !== false) || ((stripos(php_uname('r'), 'microsoft') !== false) && isWindows());
                }
                if(in_array($type, ['cmp', 'command-prompt','prompt'])){
                    $NotPSModule = getenv('PSModule') === false;
                    $HasComSpec = stripos(getenv('ComSpec'), 'cmd.exe') !== false;
                    $isMicrosoft = stripos(php_uname('v'), 'Microsoft') !== false;
                    return $NotPSModule && $HasComSpec && $isMicrosoft;
                } 
                return false;
            };
    
            foreach($terminals as $terminal){
                $response = $checkType($terminal);
                if($response === true) {
                    return (bool) $callback(); 
                }
            }
    
            return $response;
    
        }

        return false;

    }

}