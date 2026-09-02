<?php 

namespace spoova\mi\core\classes;

use Closure;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;

/**
 * This class is designed for performing simple tests on classes. 
 */
class TClass { 

    /**
     * Contains declared class name
     *
     * @var string
     */
    private ?string $className = null;

    /**
     * Contains stored methods
     *
     * @var array ['className'=> ['method'=>[rfcm => '', method=>'']]
     */
    private array $mcache = [];

    /**
     * Contains stored properties
     *
     * @var array ['className'=> ['propery'=>[rfcp => '', property=>'']]
     */
    private array $pcache = [];

    /**
     * Contains the class string
     *
     * @var string
     */
    private string $class;

    /**
     * Contains the class string after class validation
     *
     * @var string|null
     */
    private ?string $classString = null;

    /**
     * Contains the data type of class supplied. Optional "string" or "object"
     *
     * @var string|null
     */
    private ?string $classType = null;

    /**
     * Specifies if class_exist function should be used if application is not under "spoova\mi" namespace
     *
     * @var bool global
     */
    private bool $global = false;

    /**
     * Contains reflection method instance
     *
     * @var ReflectionMethod
     */
    private ?ReflectionMethod $rfcm = null;

    /**
     * Contains reflection property instance
     *
     * @var ReflectionProperty
     */
    private ?ReflectionProperty $rfcp = null;

    /**
     * Contains tested reflection method name
     *
     * @var string reflection method name
     */
    private string $method;

    /**
     * Contains tested reflection property name
     *
     * @var string reflection property name
     */
    private string $property;

    /**
     * Initializes the TClass object
     *
     * @param string|object $class 
     * @var bool $global 
     *  - FALSE uses the spoova's custom {@see appExists()} function for checking if class exists. 
     *  - TRUE enables global class checking using {@see class_exists()}. This option may throw error 
     *    if {@see TClass::getString()} is called and class does not exist.
     */
    public function __construct(string|object $class, bool $global = false)
    {
        
        if(is_object($class)) {
            $class = get_class($class);
            $this->classType = 'object';
        }else{
            $this->classType = 'string';
        }
        $this->global = $global;
        $this->class = ltrim($class, '\\');

    }

    /**
     * Returns the name of the initial class supplied
     *
     * @return string
     */
    public function getClass() : ?string {
        return $this->class;
    }

    /**
     * @uses \scheme() for returning app global namespace for the class instantiated.
     *  - This may use \appExists() or \class_exists() to check for file name depending on the global 
     *  flag option assumed during class initialization.
     *
     * @return string|false class string name or FALSE if the class does not exist.
     */
    public function getString(): string|false {
        if($this->classString) return $this->classString;
        
        $class = $this->class;

        if($this->classType === 'object'){
            return $this->classString = $class;
        }else{
            $scheme = scheme('');
            $scheme = ltrim($scheme, '\\');
            $schemeLen = strlen($scheme);
            if(strtolower(substr($class, 0, $schemeLen)) === strtolower($scheme)){
                $class = appExists(substr($class, $schemeLen), false)? $class : false;
                if($class) $this->classString = (new ReflectionClass($class))->getName();
                return $this->classString ?? false;
            }elseif($this->global === true){
                if(class_exists($class)) return $this->classString = (new ReflectionClass($class))->getName(); // may throw Error if class missing.
            }
        }

        return false;
    }

    /**
     * Returns TRUE only if method exists in specified class  within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses appExists
     *
     * @param string $name
     * @return bool FALSE is returned if the method does not exist
     */
    public function hasMethod(string $name): bool {
        return ($this->getRFCM($name)) ? true : false;
    }

    /**
     * Returns TRUE only if property exists in specified class  within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses appExists
     *
     * @param string $name
     * @return bool FALSE is returned if the property does not exist
     */
    public function hasProperty(string $name): bool {
        return ($this->getRFCP($name)) ? true : false;
    }

    /**
     * Returns TRUE only if method exists as a direct (non-inherited) method of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned only if the class does not exist or method is not directly associated with the class
     */
    public function hasDirectMethod(string $name): bool {
        if($rfcm = $this->getRFCM($name, $class)){
            $rfcName = $this->getDeclaringName($rfcm);
            return (strtolower($rfcName) === strtolower((string)$class));
        }
        return false;
    }

    /**
     * Returns TRUE only if property exists as a direct (non-inherited) property of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned only if the class does not exist or property is not directly associated with the class
     */
    public function hasDirectProperty(string $name): bool {
        if($rfcp = $this->getRFCP($name, $class)){
            $rfcName = $this->getDeclaringName($rfcp);
            return (strtolower($rfcName) === strtolower((string)$class));
        }
        return false;
    }

    /**
     * Returns TRUE only if method exists as an indirect (inherited) method of specified class  within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the class does not exist or method is not directly owned by class
     */
    public function hasInDirectMethod(string $name): bool {
        if($rfcm = $this->getRFCM($name, $class)){
            $rfcName = $this->getDeclaringName($rfcm);
            return (strtolower($rfcName) !== strtolower((string)$class));
        }
        return false;
    }

    /**
     * Returns TRUE only if property exists as an indirect (inherited) property of specified class  within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the class does not exist or property is not directly owned by class
     */
    public function hasInDirectProperty(string $name): bool {
        if($rfcp = $this->getRFCP($name, $class)){
            $rfcName = $this->getDeclaringName($rfcp);
            return (strtolower($rfcName) !== strtolower((string)$class));
        }
        return false;
    }

    /**
     * Returns TRUE only if method exists as an instance method of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the class or method does not exist or method is not static
     */
    public function hasInstanceMethod(string $name): bool {
        if($rfcm = $this->getRFCM($name, $class)){
            return !$rfcm->isStatic();
        }
        return false;
    }

    /**
     * Returns TRUE only if property exists as an instance property of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the class or property does not exist or method is not static
     */
    public function hasInstanceProperty(string $name): bool {
        if($rfcp = $this->getRFCP($name, $class)){
            return !$rfcp->isStatic();
        }
        return false;
    }


    /**
     * Returns TRUE only if method exists as a static method of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the class or method does not exist or method is not static
     */
    public function hasStaticMethod(string $name): bool {
        if($rfcm = $this->getRFCM($name, $class)){
            return $rfcm->isStatic();
        }
        return false;
    }

    /**
     * Returns TRUE only if property exists as a static property of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the class or property does not exist or method is not static
     */
    public function hasStaticProperty(string $name): bool {
        if($rfcp = $this->getRFCP($name, $class)){
            return $rfcp->isStatic();
        }
        return false;
    }

    /**
     * Returns TRUE only if method exists as a direct static method of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     * @uses TClass::hasDirectMethod()
     * @uses TClass::hasStaticMethod()
     *
     * @param string $name
     * @return bool FALSE is returned if the class or method does not exist or method is not static
     */
    public function hasDirectStaticMethod(string $name): bool {
        return $this->hasDirectMethod($name) && $this->hasStaticMethod($name);
    }

    /**
     * Returns TRUE only if method exists as a direct static property of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the class or property does not exist or method is not static
     */
    public function hasDirectStaticProperty(string $name): bool {
        return $this->hasDirectProperty($name) && $this->hasStaticProperty($name);
    }

    /**
     * Returns TRUE only if method exists as a direct non-static method of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the class or method does not exist or method is not static
     */
    public function hasDirectInstanceMethod(string $name): bool {
        return $this->hasDirectMethod($name) && !$this->hasStaticMethod($name);
    }

    /**
     * Returns TRUE only if property exists as a direct non-static property of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the class or property does not exist or method is not static
     */
    public function hasDirectInstanceProperty(string $name): bool {
        return $this->hasDirectProperty($name) && !$this->hasStaticProperty($name);
    }

    /**
     * Returns TRUE only if method exists as as a private method of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the method is not private or does not exist
     */
    public function hasPrivateMethod(string $name): bool {
        if($rfcm = $this->getRFCM($name, $class)){
            return $rfcm->isPrivate();
        }
        return false;
    }

    /**
     * Returns TRUE only if property exists as a private property of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the property is not private or does not exist
     */
    public function hasPrivateProperty(string $name): bool {
        if($rfcp = $this->getRFCP($name, $class)){
            return $rfcp->isPrivate();
        }
        return false;
    }

    /**
     * Returns TRUE only if method exists as as a protected method of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the method is not protected or does not exist
     */
    public function hasProtectedMethod(string $name): bool {
        if($rfcm = $this->getRFCM($name, $class)){
            return $rfcm->isProtected();
        }
        return false;
    }

    /**
     * Returns TRUE only if property exists as a protected property of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the property is not protected or does not exist
     */
    public function hasProtectedProperty(string $name): bool {
        if($rfcp = $this->getRFCP($name, $class)){
            return $rfcp->isProtected();
        }
        return false;
    }

    /**
     * Returns TRUE only if method exists as as a public method of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the method is not public or does not exist
     */
    public function hasPublicMethod(string $name): bool {
        if($rfcm = $this->getRFCM($name, $class)){
            return $rfcm->isPrivate();
        }
        return false;
    }

    /**
     * Returns TRUE only if property exists as a public property of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the property is not public or does not exist
     */
    public function hasPublicProperty(string $name): bool {
        if($rfcp = $this->getRFCP($name, $class)){
            return $rfcp->isPrivate();
        }
        return false;
    }

    /**
     * Returns TRUE only if method exists as an user-defined method of specified class within the project framework
     * @uses \scheme() for returning app global namespace.
     * @uses \appExists()
     *
     * @param string $name
     * @return bool FALSE is returned if the method is not user-defined.
     */
    public function hasUserDefined(string $name): bool {
        if($rfcm = $this->getRFCM($name, $class)){
            return $rfcm->isUserDefined();
        }
        return false;
    }

    /**
     * Gets old instantiated reflection method or a new one
     *
     * @param string $method class method
     * @return ReflectionMethod|false
     */
    private function getRFCM(string $method, ?string &$class = ''): ReflectionMethod|false {
        if($class = $this->getString()){
            if(method_exists($class, $method)){
                $method = strtolower($method);
                if(isset($this->mcache[$class])){
                    $mcache = $this->mcache[$class];
                    if(isset($mcache[$method])){
                        $this->rfcm = $mcache[$method]['rfcm'];
                        $this->method = $mcache[$method]['method'];
                        $this->className = $mcache[$method]['className'];
                    }else{
                        $mcache[$method] = [];
                        $mcache[$method]['rfcm'] = $this->rfcm = new ReflectionMethod($class, $method);
                        $mcache[$method]['method'] = $this->method = $method;
                        $mcache[$method]['className'] = $this->className = $this->rfcm->getDeclaringClass()->getName();
                        $this->mcache = $mcache;
                    }
                }else{
                    $mcache = $this->mcache;
                    $mcache[$class] = [];
                    $mcache[$class][$method] = [];
                    $mcache[$class][$method]['rfcm'] = $this->rfcm = new ReflectionMethod($class, $method);
                    $mcache[$class][$method]['method'] = $this->method = $method;
                    $mcache[$class][$method]['className'] = $this->className = $this->rfcm->getDeclaringClass()->getName();
                    $this->mcache = $mcache;
                }
                return $this->rfcm;
            }
        }
        return false;
    }

    /**
     * Gets old instantiated reflection property or a new one
     *
     * @param string $property class property
     * @param string $class references class namespace if supplied
     * @return ReflectionProperty|false
     */
    private function getRFCP(string $property, ?string &$class = null): ReflectionProperty|false {
        if($class = $this->getString()){
            if(property_exists($class, $property)){
                
                if(isset($this->pcache[$class])){
                    $pcache = $this->pcache[$class];
                    if(isset($pcache[$property])){
                        $this->rfcp = $pcache[$property]['rfcp'];
                        $this->property = $pcache[$property]['property'];
                        $this->className = $pcache[$property]['className'];
                    }else{
                        $pcache[$property] = [];
                        $pcache[$property]['rfcp'] = $this->rfcp = new ReflectionProperty($class, $property);
                        $pcache[$property]['property'] = $this->property = $property;
                        $pcache[$property]['className'] = $this->className = $this->rfcp->getDeclaringClass()->getName();
                        $this->pcache = $pcache;
                    }
                }else{
                    $pcache = $this->pcache;
                    $pcache[$class] = [];
                    $pcache[$class][$property] = [];
                    $pcache[$class][$property]['rfcp'] = $this->rfcp = new ReflectionProperty($class, $property);
                    $pcache[$class][$property]['property'] = $this->property = $property;
                    $pcache[$class][$property]['className'] = $this->className = $this->rfcp->getDeclaringClass()->getName();
                    $this->pcache = $pcache;
                }
                return $this->rfcp;
            }
        }
        return false;
    }

    /**
     * Gets the declaring class name
     *
     * @param ReflectionMethod|ReflectionProperty $rfc
     * @return string
     */
    private function getDeclaringName(ReflectionMethod|ReflectionProperty $rfc) : string {
       if($this->className) return $this->className;
       $rfcName = $rfc->getDeclaringClass()->getName();
       return $this->className = ltrim($rfcName, '\\');
    }

    /**
     * Creates a new instance of the TClass
     *
     * @param string|object $class
     * @param bool $global enables global class test when set as TRUE. 
     * Note that this action may throw error if {@see TClass::getString()} is called and class does not exist.
     * @return TClass
     */
    public static function class(string|object $class, bool $global = false) : TClass {
        return new self($class, $global);
    }

    /**
     * Gets the format of method.
     *
     * @param int $filter using ReflectionMethod constants.
     * @return array|false
     */
    public function get_methods_format(int $filter = ReflectionMethod::IS_PUBLIC): array|false {

        if($className = $this->getString()){

            $reflection = new ReflectionClass($className);
            $methods = $reflection->getMethods($filter);

            $output = [];

            foreach ($methods as $method) {
                if ($method->isConstructor() || $method->isDestructor()) {
                    continue; // Skip constructor/destructor
                }

                $parts = [];

                // Visibility
                if ($method->isPublic()) {
                    $parts[] = 'public';
                } elseif ($method->isProtected()) {
                    $parts[] = 'protected';
                } elseif ($method->isPrivate()) {
                    $parts[] = 'private';
                }

                // Static
                if ($method->isStatic()) {
                    $parts[] = 'static';
                }

                $parts[] = 'function';
                $parts[] = $method->getName() . '(';

                // Parameters
                $params = [];
                foreach ($method->getParameters() as $param) {
                    $paramStr = '';

                    // Type hint
                    if ($param->hasType()) {
                        $type = $param->getType();
                        if ($type instanceof ReflectionNamedType) {
                            $paramStr .= ($type->allowsNull() && !$type->isBuiltin() ? '?' : '');
                            $paramStr .= $type->getName() . ' ';
                        } elseif ($type instanceof ReflectionUnionType) {
                            $unionTypes = [];
                            foreach ($type->getTypes() as $unionType) {
                                $unionTypes[] = $unionType->getName();
                            }
                            $paramStr .= implode('|', $unionTypes) . ' ';
                        }
                    }

                    // Variadic
                    if ($param->isVariadic()) {
                        $paramStr .= '...';
                    }

                    // Reference
                    if ($param->isPassedByReference()) {
                        $paramStr .= '&';
                    }

                    $paramStr .= '$' . $param->getName();

                    // Default value
                    if ($param->isOptional() && !$param->isVariadic()) {
                        if ($param->isDefaultValueAvailable()) {
                            $default = $param->getDefaultValue();
                            $paramStr .= ' = ' . var_export($default, true);
                        } else {
                            $paramStr .= ' = null'; // Optional but no default explicitly
                        }
                    }

                    $params[] = $paramStr;
                }

                $parts[] = implode(', ', $params) . ')';

                // Return type
                if ($method->hasReturnType()) {
                    $returnType = $method->getReturnType();
                    if ($returnType instanceof ReflectionNamedType) {
                        $parts[] = ': ' . ($returnType->allowsNull() && !$returnType->isBuiltin() ? '?' : '') . $returnType->getName();
                    } elseif ($returnType instanceof ReflectionUnionType) {
                        $types = [];
                        foreach ($returnType->getTypes() as $t) {
                            $types[] = $t->getName();
                        }
                        $parts[] = ': ' . implode('|', $types);
                    }
                }

                $format = implode(' ', $parts);
                $output[$method->getName()] = str_replace('( ', '(', $format);
            }
        }
        return $output ?? false;
    }

    /**
     * Gets the argument of a function
     *
     * @param Closure|string $function
     * @param boolean|string $values By default the argument data type is returned as values. If this is set as TRUE, then the default value of 
     * the argument will be returned. However, note that required arguments will have a default of NULL or you can specify a custom string value 
     * to be returned for required arguments. For example, a value ':required' will be the default value for required arguments. To keep the default data type, ensure that this 
     * argument remain set as FALSE.
     * @return array
     */
    static function funcParams(Closure|string $function, bool|string $values = false) : array {
        if(is_closure($function) || function_exists($function)){
            $reflection = new ReflectionFunction($function);
            $parameters = $reflection->getParameters();
            $types = [];
            foreach($parameters as $key => $parameter){

                $type =  $parameter->getType(); // get the type(s) of parameter supplied

                if($values || is_string($values)){
                    $types[$parameter->getName()] = $parameter->isDefaultValueAvailable()? $parameter->getDefaultValue() : (is_string($values)? $values : null);
                }else{
                    if($type instanceof ReflectionUnionType){
                        $types[$parameter->getName()] = array_map(fn($t) => $t->getName(), $type->getTypes());
                    }else if($type instanceof ReflectionNamedType){
                        $types[$parameter->getName()] = [$type->getName()];
                    }else{
                        $types[$parameter->getName()] = '';
                    }
                }
            }
            return $types;
        }else{
            return [];
        }
    }

}