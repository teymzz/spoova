<?php 

namespace spoova\mi\core\commands\Root\Cli\Enums;

/**
 * This class contains modifier constants or options for the 
 * Cli::animeList() method.
 */
enum AnimeList {

    /**
     * Animation modifier for generators. 
     * This modifier should be applied for 
     */
   case Yield;

    /**
     * Animation modifier for generators. 
     * This modifier should be applied for 
     */
   case YieldGrow;

    /**
     * Animation modifier for arrays. This modifier 
     * should be applied for arrays that contains list of anonymous functions 
     * that are expected to be treated as animation steps. Each function defined within array 
     * will be animated sequentially.
     */
    case Steps;

    /**
     * Animation modifier for arrays. This modifier 
     * should be applied for arrays that contains list of anonymous functions 
     * that are expected to be treated as animation steps. Each function defined within array 
     * will be animated sequentially.
     */
    case StepsGrow;

}