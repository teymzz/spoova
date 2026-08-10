<?php

namespace spoova\mi\core\classes\Container;

use Closure;
use Error;
use Exception;
use Reflection;
use ReflectionClass;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;
use spoova\mi\core\classes\Debug;
use spoova\mi\core\classes\Sensor\Sensor;
use Throwable;

class Container {

    /**
     * Anchors the instance of the Container class
     *
     * @var Container
     */
    private static ?Container $instance = null;

    /**
     * Deteremines dependencies that are bound
     *
     * @var array
     */
    private array $bindings = [];

    /**
     * Determines dependencies that are resolved
     *
     * @var array
     */
    private array $resolved = [];

    /**
     * Determines values assigned to properties
     *
     * @var array
     */
    private array $propertyValues = [];

    /**
     * Contains all providers
     *
     * @var array
     */
    private array $providers = [];
    
    /**
     * Determines when a dependency is currently being resolved
     *
     * @var array
     */
    private array $resolving = [];

    /**
     * Keeps instance of a resolve class
     *
     * @var array
     */
    private array $resolvedInstance = [];

    /**
     * Track dependency resolution order
     *
     * @var array
     */
    private array $resolutionStack = [];

    /**
     * Applies a list of feeder values for dependencies when within a feeder scope
     *
     * @var array
     */
    private array $feeders = []; 

    /**
     * Determines if a feeder is consistently supplied through for all dependencies
     *
     * @var boolean
     */
    private bool $feedALL = false;
    private bool $booted = false;
    private string $order = 'dependencies';
    private array $registerMethods = []; // Stores custom methods per class
    private string $register_method = 'register';
    private bool $locked = false;

    /**
     * Prevents accidental re-initialization
     */
    private function __construct(){ }

    /**
     * Return instance of container class
     *
     * @return self
     */
    public static function instance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Bind services directly from container
     *
     * @param string $abstract class to be resolved
     * @param Closure|string|null $concrete
     * @param boolean $shared
     * @return void
     */
    public function bind(string $abstract, $concrete = null, bool $shared = false): void {
        if ($this->locked) {
            throw new Exception("Container is locked. Cannot bind new services.");
        }
        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'shared' => $shared
        ];
    }

    /**
     * Defines the method which the {@see Container::register()} uses to resolve service provider. Default is 'register'
     *  - Warning!!! This method will modify the default behaviour of {@see Container::register()} method for service providers.
     * @param string $method internal method to be called by register method.
     * @return Container
     */
    public function with(string $method) {
        if(!$method){
            throw new Exception("Invalid handler method supplied.");
        }
        $this->register_method = $method? $method : $this->register_method;
        return $this;
    }

    /**
     * Register a service provider
     *
     * @param string $provider provider class
     * @param Closure|null $resolver if defined supplies argument to string of $provider during initialization 
     *  - Note that when an array is returned by $resolver, the array values are parsed as arguments of $provider if initialized 
     * @return Container
     */
    public function register(string $provider, Closure|array $resolver = []) {

        if(!trim($provider)){
            throw new Error('cannot register null as provider');
        }

        // If class is already registered, return early
        if (isset($this->providers[$provider])) return;

        $register_method = $this->register_method; // Get the current method
        $register = 'register';

        if (!method_exists($provider, $register_method)) {
            throw new Exception("Class [$provider] does not have [$register_method] registration method.");
        }
        
        // Return constructor arguments using the closure or array value supplied as second argument
        $args = $resolver instanceof Closure ? $resolver($this) : $resolver;

        if (!is_array($args) && !is_object($args) && !is_scalar($args)) {
            throw new Exception("Invalid return type from resolver. Expected array, scalar, or object.");
        }

        // Ensure args is an array or a single value
        if (!is_array($args)) $args = [$args];

        $providerInstance = $provider;
        $provider = is_object($provider)? get_class($provider) : $provider;
        $method = $this->register_method;
        $register = 'register'; //default method

        // Store custom register method for ONLY specified providers while other uses default 'register'
        if ($this->register_method !== $register) $this->registerMethods[$provider] = $method;

        // Reset custom register method back to the default method name after registration
        $this->register_method = $register;

        if (!isset($this->providers[$provider])) {

            // Use stored method if available, otherwise default to 'register'
            $methodToCall = $this->registerMethods[$provider] ?? $register;
            // Apply register method before provider has been stored
            $reflection = new ReflectionMethod($provider, $methodToCall);
            $reflection->invokeArgs(null, [$this]); // preferred register handler method must be a static method.
        }

        $providerInstance = $this->make($provider, $args);  // Initialize class and apply Automatic dependency injection;

        // Ensure provider is resolved when needed
        if (!isset($this->bindings[$provider])) {
            if(is_object($providerInstance)){
                $this->bind($provider, fn() => $providerInstance);
            }
        }
    
        // Register the provider if not already registered
        if (!isset($this->providers[$provider])) {
            $this->providers[$provider] = $providerInstance;
        }
        return $this;
    }    

    /**
     * Boot all providers (only runs once)
     *
     * @return void
     */
    public function boot() {
        if (!$this->booted) {
            foreach ($this->providers as $provider) {
                if(method_exists($provider, 'boot')) $provider->boot();
            }
            $this->booted = true;
        }
    }

    /**
     * Resolve services by initializing dependencies or accessing initialized dependencies
     *
     * @param string $abstract class to be resolved
     * @param array $args parsed argument for methods
     * @param bool $allowsNull determines if null should be returned
     * @return object|null
     */
    public function make(string $abstract, array $args = [], bool $allowsNull = false) : object|null{
        if (isset($this->resolved[$abstract])) {
            return $this->resolved[$abstract];
        }
        if (isset($this->resolving[$abstract])) {
            throw new Exception("Circular dependency detected while resolving [{$abstract}].");
        }
    
        $this->resolving[$abstract] = true;
    
                
        if (isset($this->bindings[$abstract])) {
            $bindings = $this->bindings[$abstract];
            $resolved = &$this->resolved[$abstract];

            $concrete = $bindings['concrete'];
            if($concrete instanceof Closure){
            }
            $instance = ($concrete instanceof Closure) ? $concrete($this) : $this->resolveClass($concrete, $args, $allowsNull);
            $this->resolvedInstance[$abstract] = $instance;
            unset($this->resolving[$abstract]);
    
            if ($bindings['shared']) {
                $resolved[$abstract] = $instance;
            }
            
            if(!$instance && !$allowsNull){
                throw new Exception('Cannot resolve class "'.$abstract.'"');
            }
            return $instance;
        }
    
        if (class_exists($abstract)) { 
            $instance = $this->resolveClass($abstract, $args, $allowsNull);
            $this->resolvedInstance[$abstract] = $instance;
            unset($this->resolving[$abstract]);
            return $instance;
        }
    
        throw new Exception("Service [{$abstract}] not found in container.");
    }

    /**
     * Returns a resolved instance
     *
     * @return object|null
     */
    public function getResolvedInstance(string $abstract) : object|null {
        if(isset($this->resolvedInstance[$abstract])){
            return $this->resolvedInstance[$abstract];
        }
        return null;
    }
    /**
     * Returns a resolved instances
     *
     * @return array
     */
    public function getResolvedInstances() : array {
        return $this->resolved ?? [];
    }

    /**
     * Applies {@see Container::register()}, {@see Container::boot()} and {@see Container::make()} at once.
     *  - Note that only arguments can be supplied during a dispatch
     *  - This should only be used in a situation where boot() is permitted to be applied before the make() method. 
     */
    public function dispatch(string $class, array $args = [])  {
        $this->register($class, $args);
        $this->boot();
    }

    private function resolveClass(string $class, array $args = [], bool $allowsNull = false) {
        $reflection = new ReflectionClass($class);
    
        // Return null if class is abstract or an interface and null is allowed
        if (($reflection->isAbstract() || $reflection->isInterface()) && $allowsNull) {
            return null;
        }

        $constructor = $reflection->getConstructor();
        
        $dependencies = $constructor ? $this->resolveDependencies($reflection, $constructor->getParameters(), $args) : [];
    
        // Apply static property injection before instantiation
        if ($this->propertyValues) {
            $this->applyPropertyValues($reflection);
        }

        // Instantiate class with resolved dependencies
        $instance = new $class(...$dependencies);
    
        // Apply instance property injection after instantiation
        if ($this->propertyValues) {
            $this->applyPropertyValues($reflection, $instance);
        }
    
        return $instance;
    }    
    
    private function resolveDependencies(ReflectionClass|ReflectionFunctionAbstract $reflection, array $parameters, array $arguments): array {

        $dependencies = [];
        $arguments = array_values($arguments); // Reset array keys for positional arguments

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            $name = $parameter->getName();

            // Handle ReflectionUnionType (PHP 8+)
            if ($type instanceof ReflectionUnionType) {
                $resolved = false;
                $allowsNull = $type->allowsNull(); // Check if null is allowed
    
                foreach ($type->getTypes() as $unionType) {
                    if (!$unionType->isBuiltin()) {
                        try {
                            $dependencies[] = $this->make($unionType->getName(), [], $unionType->allowsNull());
                            $resolved = true;
                            break;
                        } catch (Throwable) {
                            // Ignore and try next type
                        }
                    }else{
                        $resolved = true;
                    }
                }
    
                // If no type was resolved but nullable is allowed, assign null
                if (!$resolved && $allowsNull) {
                    $dependencies[] = null;
                    continue;
                }
    
                // If still unresolved, throw an error
                if (!$resolved) {
                    throw new Error("Could not resolve any type for parameter '{$name}'");
                }
                continue;
            }
    
            // Handle Single Type (Non-Union)
            if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                $dependencies[] = $this->feeders[$name] ?? $this->make($type->getName(), [], $type->allowsNull());
                if (!$this->feedALL) unset($this->feeders[$name]);
            } elseif (isset($this->feeders[$name])) {
                // Resolve from feeders
                $dependencies[] = $this->feeders[$name];
                if (!$this->feedALL) unset($this->feeders[$name]);
            } elseif (isset($arguments[0])) {
                // Use positional arguments
                $dependencies[] = array_shift($arguments);
            } elseif ($parameter->isDefaultValueAvailable()) {
                // Use default value if provided
                $dependencies[] = $parameter->getDefaultValue();
            } elseif ($type?->allowsNull()) {
                // If the type is nullable, assign null
                $dependencies[] = null;
            } else {
                throw new Error("Parameter '{$name}' is required but not supplied");
            }
        }
    
        return ($this->order === 'dependencies') ? array_merge($dependencies, $arguments) : array_merge($arguments, $dependencies);
    }   
    
    
    /**
     * Determines values that are feeded to dependencies
     *
     * @param array $feeders
     * @param Closure $callback 
     * @param boolean $consistency  
     * @return array
     */
    public static function feeder(array $feeders, Closure $callback, bool $consistency = false){

        $instance = self::instance();
        
        // apply feeder to defined dependencies
        $instance->feeders = $feeders;
        $instance->feedALL = $consistency;

        $callback($instance);
        
        // reset feeder to default behaviour
        $instance->feeders = [];
        $instance->feedALL = false;

    }

    /**
     * Resolve class methods
     *
     * @param object|string $instance instance of class
     * @param string $method method to be resolved
     * @param array $arguments parsed arguments
     * @return mixed
     */
    public static function callMethod($instance, string $method, Closure|array $arguments = []) {
        $reflection = new ReflectionMethod($instance, $method);
        $parameters = $reflection->getParameters();
        $tthis = Container::instance();
        if($arguments instanceof Closure){
            $args = $arguments($tthis);
            if (!is_array($args) && !is_object($args) && !is_scalar($args)) {
                throw new Exception("Invalid return type from resolver. Expected array, scalar, or object.");
            }
            if(!is_array($args)) $args = [$args];
            $arguments = $args;
        }

        $args = $tthis->resolveDependencies($reflection, $parameters, $arguments);

        $args = array_values($args);
        if ($reflection->isStatic()) {
            return $reflection->invokeArgs(null, $args); // Use `null` for static method calls
        }
        return $reflection->invokeArgs(is_string($instance) ? $tthis->make($instance) : $instance, $args);
    }

    /**
     * Resolve anonymous functions
     *
     * @param Closure $function anonymous function to be resolved
     * @param array $arguments parsed arguments
     * @return mixed
     *  - Note that false is returned if the argument supplied is not a Closure
     */
    public function callFunction($function, array $arguments = []) {
        if(!($function instanceof Closure)) return false;
        $reflection = new ReflectionFunction($function);
        $parameters = $reflection->getParameters();        
        
        $args = $this->resolveDependencies($reflection, $parameters, $arguments);
     
        return $reflection->invokeArgs($args);
    }

    /**
     * Set specific properties value for classes
     *
     * @param array $propertyValues
     * @return Container
     */
    public function properties(array $propertyValues): Container {
        $this->propertyValues = $propertyValues;
        return $this;
    }

    private function applyPropertyValues(ReflectionClass &$reflection, ?object $instance = null): void {
        foreach ($this->propertyValues as $property => $value) {
            if($reflection->hasProperty($property)){
                //modify private, protected and public properties
                $prop = $reflection->getProperty($property);
                if($prop->isStatic()){
                    $prop->setAccessible(true); 
                    $prop->setValue(null, $value);
                }elseif($instance){
                    $prop->setValue($instance, $value);
                }
            }
        }
    }

    /**
     * Checks if a class is bound
     *
     * @param string $abstract
     * @return boolean
     */
    public function isBound(string $abstract): bool {
        return isset($this->bindings[$abstract]);
    }

    /**
     * Returns container bindings
     *
     * @return array
     */
    public function bindings(): array {
        return $this->bindings;
    }

    /**
     * Set dependency order
     *
     * @param string $order
     * @return void
     */
    public function setOrder(string $order = 'dependencies'): void {
        $orders = ['dependencies', 'arguments'];
        if (in_array($order, $orders)) {
            $this->order = $order;
        }
    }

    /**
     * Returns TRUE if binding of new services is disabled
     *
     * @return boolean
     */
    public function isLocked(): bool {
       return $this->locked;
    }

    /**
     * Disables the binding of new services
     *
     * @return void
     */
    public function lock(): void {
        $this->locked = true;
    }

    /**
     * Enables the binding of new services
     *
     * @return void
     */
    public function unlock(): void {
        $this->locked = false;
    }
}
