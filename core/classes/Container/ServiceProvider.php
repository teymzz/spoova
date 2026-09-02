<?php

namespace spoova\mi\core\classes\Container;

abstract class ServiceProvider {
    protected Container $app;

    public function __construct(Container $app) {
        $this->app = $app;
    }

    abstract public function register();

    // Optional: Runs after all services are registered
    public function boot() {}
}
