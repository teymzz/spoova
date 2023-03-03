<?php

namespace teymzz\spoova\core\commands;

class Test {

    public function __construct($animeType){
        Cli::animeType($animeType);
        Cli::runAnime([$this, 'trial']);
    }

    public function trial() {
        Cli::loadTime(50000);
       
        yield from Cli::play(5, 0, 'HI there');
        Cli::animeType('roller');
        Cli::pause(2);
        yield from Cli::play(2);
        //Cli::break();
        yield from Cli::play(5, 0, 'This me');
    }


}