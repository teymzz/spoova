<?php

// Format used for Video Animation Samples
// namespace spoova\mi\commands;

// use \spoova\mi\core\commands\Consoler\Consoler;
// use \spoova\mi\core\commands\Root\Cli;

// class Template extends Consoler {
        
//     /**
//      * Set the maximum number of arguments allowed.
//      */
//     protected static int $args_max = 5;

//     /**
//      * Set arguments and options allowed on this command
//      *
//      * @return array
//      */
//     public static function setOps() : array {

//         return [
//             'animate' => 'animate',

//             fn() => [
                
//                 '' => 'This is '.Cli::alert('template').' command.',
//                 'animate' => [
//                     'i' => 'this is description for "'.Cli::warn('animate').'".',
//                     'x' => Cli::warn('php mi').' '.Cli::alert('cat::template').' '.Cli::valid('animate'),
//                 ]
//             ]
//         ];

//     }

//     public static function animate() {
        
//         $message = 'Hello there! This is spoova text animation.'; // text to be pulsated

//         Cli::pulseView($message); // animate text in pulse mode

//         Cli::break(2); // break 2 lines after animation

//     }

// }