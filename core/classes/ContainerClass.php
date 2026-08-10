<?php

namespace spoova\mi\core\classes;

use Closure;
use Exception;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

class ContainerClass
{
    private static $instance;
    private static $order = 'dependencies';
    private $bindings = [];
    private $resolved = [];
    private $lastResolvedClass;
    private array $lastArgs = [];

    // Singleton pattern to ensure only one instance of the container exists
    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Bind services to the container
    public function bind(string $abstract, $concrete = null, bool $shared = false)
    {
        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'shared' => $shared,
        ];
    }

    // Resolve the service (instantiate it or return shared instance)
    public function make(string $abstract, array $parsedArgs = [])
    {
        if (isset($this->resolved[$abstract])) {
            return $this->resolved[$abstract];
        }

        if (isset($this->bindings[$abstract])) {
            $concrete = $this->bindings[$abstract]['concrete'];
            
            $instance = ($concrete instanceof Closure)
                ? $concrete($this, $parsedArgs)
                : $this->resolveClass($concrete, $parsedArgs);

            if ($this->bindings[$abstract]['shared']) {
                $this->resolved[$abstract] = $instance;
            }

            return $instance;
        }

        throw new Exception("Service [{$abstract}] not found in container.");
    }

    // Resolve a class and inject dependencies
    private function resolveClass(string $class, array $parsedArgs = [])
    {
        $this->lastResolvedClass = $class;
        
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        $dependencies = $constructor ? $this->resolveDependencies($constructor->getParameters(), $parsedArgs) : [];
        
        $instance = $reflection->newInstanceArgs($dependencies);
        $this->resolveMethodDependencies($instance);
        $this->resolveStaticMethodDependencies($class);
        
        return $instance;
    }

    /**
     * Resolve dependencies for constructor or methods
     * @param ReflectionParameter[] $parameters
     * @param array $parsedArgs
     * @return array
     */
    private function resolveDependencies(array $parameters, array $parsedArgs = []): array
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();

            if ($type instanceof ReflectionUnionType) {
                // Handle union types, prioritize resolving class types
                foreach ($type->getTypes() as $unionType) {
                    if ($unionType instanceof ReflectionNamedType && !$unionType->isBuiltin()) {
                        $dependencies[] = $this->make($unionType->getName(), $parsedArgs);
                        continue 2;
                    }
                }
            } elseif ($type instanceof ReflectionNamedType) {
                if (!$type->isBuiltin()) {
                    $dependencies[] = $this->make($type->getName(), $parsedArgs);
                } else {
                    $dependencies[] = $this->resolveParsedArgument($parameter, $parsedArgs);
                }
            } else {
                $dependencies[] = $this->resolveParsedArgument($parameter, $parsedArgs);
            }
        }

        return $dependencies;
    }

    /**
     * Resolve primitive arguments (e.g., string, int, bool)
     */
    private function resolveParsedArgument(ReflectionParameter $parameter, array $parsedArgs = [])
    {
        $paramName = $parameter->getName();

        if (array_key_exists($paramName, $parsedArgs)) {
            return $parsedArgs[$paramName];
        }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        return null;
    }

    // Resolve method dependencies (instance methods)
    private function resolveMethodDependencies($instance)
    {
        $reflection = new ReflectionClass($instance);
        foreach ($reflection->getMethods() as $method) {
            if (!$method->isStatic() && $method->getNumberOfParameters() > 0) {
                $methodDependencies = $this->resolveDependencies($method->getParameters());
                $method->invokeArgs($instance, $methodDependencies);
            }
        }
    }

    // Resolve static method dependencies
    private function resolveStaticMethodDependencies(string $class)
    {
        $reflection = new ReflectionClass($class);
        foreach ($reflection->getMethods(ReflectionMethod::IS_STATIC) as $method) {
            if ($method->getNumberOfParameters() > 0) {
                $methodDependencies = $this->resolveDependencies($method->getParameters());
                $method->invokeArgs(null, $methodDependencies);
            }
        }
    }

    /**
     * Set argument priority order
     * @param string $order [dependencies|arguments]
     */
    public static function setOrder(string $order = 'dependencies')
    {
        if (in_array($order, ['dependencies', 'arguments'])) {
            self::$order = $order;
        }
    }

    /**
     * Get the last resolved class
     */
    public function getClass(): string
    {
        return $this->lastResolvedClass;
    }

    /**
     * Get the last parsed arguments
     */
    public function args(): array
    {
        return $this->lastArgs;
    }

    // Check if a service is bound
    public function bound(string $abstract): bool
    {
        return isset($this->bindings[$abstract]);
    }
}