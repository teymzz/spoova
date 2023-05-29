<?php

namespace spoova\mi\windows\Routes\Docs\V2;

use Window;

class BondComponents extends Window {

    function __construct()
    {
        
        self::addRex();
        self::call($this, [

            lastCall('/bond-components') => 'root',
            lastCall('/bond-components/variables') => 'variables',
            lastCall('/bond-components/life-events') => 'lifeEvents',
            lastCall('/bond-components/counter') => 'counter',
            lastCall('/bond-components/real-time') => 'realTime',
            lastCall('/bond-components/forms') => 'forms',
            lastCall('/bond-components/button-events') => 'buttonEvents',
            lastCall('/bond-components/form-data') => 'formData',
            lastCall('/bond-components/notice') => 'notice',

        ]);

    }

    function root() {
        self::load('version.2v0.bond-components.main', fn() => compile());
    }

    function variables() {
        self::load('version.2v0.bond-components.variables', fn() => compile());
    }

    function lifeEvents() {
        self::load('version.2v0.bond-components.life-events', fn() => compile());
    }

    function counter() {
        self::load('version.2v0.bond-components.counter', fn() => compile());
    }

    function realTime() {
        self::load('version.2v0.bond-components.real-time', fn() => compile());
    }

    function forms() {
        self::load('version.2v0.bond-components.forms', fn() => compile());
    }

    function buttonEvents() {
        self::load('version.2v0.bond-components.button-events', fn() => compile());
    }

    function formData() {
        self::load('version.2v0.bond-components.form-data', fn() => compile());
    }

    function notice() {
        self::load('version.2v0.bond-components.notice', fn() => compile());
    }

}