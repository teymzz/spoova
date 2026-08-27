<?php 

namespace spoova\mi\core\classes;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Session;
use spoova\mi\core\classes\Container\Container;
use Dom\HTMLDocument;
use Dom\Element;

abstract class BondComponent{

    private static $body = '';
    private static $bondAjax = [];
    private static BondComponent $instance;
    protected $bondID;

    /**
     * Session key holding every bond state belonging to the current visitor.
     *
     * State used to travel in a "bondJS" cookie which the client could rewrite at will,
     * so any public property of a bond was effectively client supplied. It is kept on the
     * server now and the browser only ever sees the bond's id.
     */
    private const STATE_KEY = ':BONDS';

    /** state entry holding the token a bond request is verified with */
    private const TOKEN_KEY = ':token';

    /** how many bond states are retained before the oldest are dropped */
    private const STATE_LIMIT = 60;

    /** field messages set by a handler through addError() */
    private array $bondErrors = [];

    /**
     * The fields a bond restores after a re-render.
     *
     * Kept identical to the selector bond.js collects with, so both ends of the round
     * trip always see the same set. Buttons carry no user input and a file input cannot
     * be assigned a value, so they are excluded.
     */
    private const FIELDS = 'input:not([type="submit"]):not([type="button"])'
                         .':not([type="reset"]):not([type="image"]):not([type="file"])'
                         .', textarea, select';

    function __construct() {}

    /**
     * Records a validation message against a form field.
     *
     * The messages are handed to the template as $errors, keyed by field name, and each
     * matching field is marked with bond:invalid in the rendered output.
     *
     * @param string $field value of the field's name attribute
     * @param string $message message to report for it
     * @return static
     */
    final public function addError(string $field, string $message) : static {
        $this->bondErrors[$field] = $message;
        return $this;
    }

    /**
     * Returns validation messages recorded for the current render
     *
     * @param string|null $field a field name, or NULL for every message
     * @return array|string an array keyed by field name, or that field's message ('' if none)
     */
    final public function errors(?string $field = null) : array|string {
        if($field === null) return $this->bondErrors;
        return $this->bondErrors[$field] ?? '';
    }

    /**
     * Determines if any validation message was recorded
     *
     * @return boolean
     */
    final public function hasErrors() : bool {
        return $this->bondErrors !== [];
    }

    /**
     * Clears every recorded validation message
     *
     * @return static
     */
    final public function clearErrors() : static {
        $this->bondErrors = [];
        return $this;
    }

    /**
     * Render components
     *
     * @return Compiler|String A compile string or Compiler item.
     * 
     *    - Note: A rendered string should not be returned
     */
    public function render(): Compiler|String {
        return '';
    }

    final public function content() {
       return static::$body;
    }

    /**
     * Resolve bond
     *
     * @param string $space Bond controller space within the windows\Bonds namespace
     * @param array $args
     * @param string $key optional name that identifies this bond among others of the same
     * controller. Supply one where the same controller is rendered more than once on a page
     * and the order it is rendered in can change.
     * @return string
     */
    final public function resolve($space, array $args = [], string $key = '') : string {
        $id = self::bondIdentity($space, $key);
        $namespace = to_frontslash('windows.Bonds.'.$space, true);
        $bondClass = scheme($namespace);

        $bondClass = "\\".to_backslash(url($bondClass)->pathmod(fn($x) => ucfirst($x), -1));

        if(appExists($namespace)) {

            $class = Container::instance()->make($bondClass, [1]);
            $class->setBond($id);
            $class->mount();

            self::$instance = $instance = $class;
            $props = $class->bondProperties($instance);

            $assigned = [];

            //overwrite properties if not initially set
            foreach($props as $bondVar => $bondVal) {

                if(!isset($instance->$bondVar)){
                    if(isset($args[$bondVar])){
                        $assigned[$bondVar] = $instance->$bondVar = $args[$bondVar];
                    }
                }else{
                    $assigned[$bondVar] = $instance->$bondVar;
                }

            }
 
            //override bond directive arguments with assigned properties
            $newargs = $assigned;

            $this->bindAjax($instance, $id, $newargs);

            // expose whatever the handler reported through addError() to the template as
            // $errors, so a field message can be printed beside the field that caused it
            $newargs['errors'] = $class->errors();

            $content = $class->render(); //render updated content

            //merge arguments
            
            if($content instanceof Compiler){
                $newargs = array_merge($newargs, $content->getArgs());
                
                $content->setBase(to_frontslash('_bonds/'.$space, true));
                $content->setArgs($newargs);
                $content = $content->body($content->raw());
                $content = (string) $content;

            }else{

                $Compiler = new Compiler;
                $Compiler->setBase(to_frontslash('_bonds/'.$space, true));
                $Compiler->setArgs($newargs);
                $Compiler->body($content);
                $content = (string) $Compiler;
                
            }

            if ($content) {
                // New PHP 8.4+ HTML parser — no more libxml error suppression needed
                $dom = HTMLDocument::createFromString(
                    $content,
                    LIBXML_NOERROR,
                    'UTF-8'
                );

                $rootItem = self::bondRoot($dom);

                if ($rootItem instanceof Element) {
                    // Set custom attribute
                    $rootItem->setAttribute('bond:root', $id);

                    /* bond.js reads this back off the root and returns it with every call, so a
                       page from another origin cannot drive a bond method: it can post to the
                       url but cannot read the token out of the response. It is a session value
                       of its own rather than the form CSRF token, which rotates whenever a
                       template renders @csrf and would leave the attribute stale. */
                    $rootItem->setAttribute('bond:csrf', self::bondToken());

                    /* CSS selectors rather than XPath.

                       Dom\HTMLDocument places every element in the XHTML namespace, so an
                       unprefixed XPath name test such as "//input" matches nothing at all —
                       it would need "//*[local-name()='input']" or a registered prefix.
                       querySelectorAll is namespace-agnostic, is scoped to $rootItem by
                       construction, and is the same selector bond.js uses to collect the
                       values, so both ends of the round trip stay in step.

                       file is the only exclusion beyond the buttons: a value cannot be
                       assigned to it. checkbox and radio are included because bond.js now
                       reports their checked state, which setFieldValue() restores. */
                    $fields = $rootItem->querySelectorAll(self::FIELDS);

                    $bondArgs = $class->bondArguments('data');

                    if ($bondArgs && $fields->length) {

                        /* bond.js already sends {name, value, checked} per field. Matching on
                           name instead of position means a field that is conditionally
                           rendered, added or removed between renders cannot shift every later
                           value onto the wrong input — and a short payload cannot raise an
                           undefined-key error part way through. */
                        $sentByName = [];
                        foreach ($bondArgs as $sent) {
                            if (!is_array($sent)) continue;
                            $sentName = $sent['name'] ?? '';
                            if ($sentName !== '' && $sentName !== null) $sentByName[$sentName] = $sent;
                        }

                        $counter = 0;

                        foreach ($fields as $field) {

                            $fieldName = $field->getAttribute('name');

                            if ($fieldName !== '' && array_key_exists($fieldName, $sentByName)) {
                                $sent = $sentByName[$fieldName];
                            } elseif (isset($bondArgs[$counter]) && is_array($bondArgs[$counter])) {
                                $sent = $bondArgs[$counter]; // unnamed field: fall back to position
                            } else {
                                $counter++;
                                continue; // nothing was sent for this field, leave the template's own value
                            }

                            $counter++;
                            self::setFieldValue($field, $sent);

                        }

                        // Refresh CSRF tokens
                        $csrfFields = $rootItem->querySelectorAll('input[type="hidden"][name="CSRF_TOKEN"]');
                        foreach ($csrfFields as $csrfField) {
                            $csrfField->setAttribute('value', CSRF::old());
                        }
                    }

                    /* flag the fields the handler rejected, so a stylesheet can mark them
                       without the template having to test $errors on every input */
                    foreach ($class->errors() as $errorField => $errorMessage) {
                        foreach ($rootItem->querySelectorAll(self::FIELDS) as $field) {
                            if ($field->getAttribute('name') === (string) $errorField) {
                                $field->setAttribute('bond:invalid', 'true');
                            }
                        }
                    }

                    // Serialize back — only the body's inner content, not the full doc
                    $content = $dom->body->innerHTML;
                }
            }

            

            return $content;

        } else {

            EInfo::view('Bond class "'.$bondClass.'" missing');

        }

        return '';

    }

    /**
     * Stores the id of a rendered bond
     *
     * @param string $id the bond's identity, also written to the bond:root attribute
     * @return void
     */
    final public function setBond(string $id){
        $this->bondID = $id;
    }

    /**
     * Returns the single element a bond is mounted on.
     *
     * bond.js addresses a rendered bond with querySelector('[bond:root="id"]'), which is
     * singular, so a component that renders sibling elements would leave everything after
     * the first unmanaged — its events unbound and its fields never restored. When that
     * happens the whole component is wrapped in one plain element so it stays addressable.
     * The wrapper carries bond:wrap, and only appears when it is actually needed.
     *
     * @param HTMLDocument $dom the parsed component
     * @return Element|null NULL when the component rendered no element at all
     */
    private static function bondRoot(HTMLDocument $dom) : ?Element {

        $body = $dom->body;

        if (!$body) return null;

        $roots = 0;
        foreach ($body->childNodes as $node) {
            if ($node instanceof Element) $roots++;
        }

        if ($roots === 0) return null;
        if ($roots === 1) return $body->firstElementChild;

        $wrapper = $dom->createElement('div');
        $wrapper->setAttribute('bond:wrap', 'true');

        // every node moves, not just the elements, so text between them keeps its place
        while ($body->firstChild) {
            $wrapper->appendChild($body->firstChild);
        }

        $body->appendChild($wrapper);

        return $wrapper;

    }

    /**
     * Writes a submitted value back onto a rendered field.
     *
     * Each field type carries its state differently, so a single setAttribute('value')
     * is only correct for text-like inputs.
     *
     * @param Element $field the rendered form field
     * @param array $sent the {name, value, checked} entry bond.js reported for it
     * @return void
     */
    private static function setFieldValue(Element $field, array $sent) : void {

        $tag = strtolower($field->tagName);
        $value = (string) ($sent['value'] ?? '');

        if ($tag === 'textarea') {
            $field->textContent = $value;
            return;
        }

        if ($tag === 'select') {
            // a select has no value attribute: the selection lives on its options
            foreach ($field->getElementsByTagName('option') as $option) {
                $optionValue = $option->hasAttribute('value')? $option->getAttribute('value') : $option->textContent;
                if ($optionValue === $value) {
                    $option->setAttribute('selected', 'selected');
                } else {
                    $option->removeAttribute('selected');
                }
            }
            return;
        }

        $type = strtolower($field->getAttribute('type'));

        if ($type === 'checkbox' || $type === 'radio') {
            /* state is "checked" here; value= is what the field submits and must survive.
               A payload from an older client carries no checked key, so the field is left
               exactly as the template rendered it rather than being silently unchecked. */
            if (!array_key_exists('checked', $sent)) return;

            if (filter_var($sent['checked'], FILTER_VALIDATE_BOOLEAN)) {
                $field->setAttribute('checked', 'checked');
            } else {
                $field->removeAttribute('checked');
            }
            return;
        }

        $field->setAttribute('value', $value);

    }

    /**
     * Returns the id of the bond root element
     *
     * @return string
     */
    final public function bondID(){
       return $this->bondID;
    }

    /**
     * Returns the value of a specified bond data key
     *
     * @param string $key
     * @return array
     */
    final public function bondArguments($key) : array {

        return self::$bondAjax[(string) $this->bondID][$key] ?? [];

    }

    /**
     * Restores a bond's state, runs the method a request asked for and stores the state back.
     *
     * A bond request addresses exactly one component. Every bond on the page is resolved on
     * the way to rendering the response, so each one has to establish whether the request was
     * meant for it before touching anything: without that check a method name was run on every
     * bond that happened to define it, and one component's submitted fields were written onto
     * another's.
     *
     * @param BondComponent $class the bond being resolved
     * @param string $id the bond's identity
     * @param array $args properties handed on to the template
     * @return void
     */
    private function bindAjax(BondComponent $class, string $id, &$args) {

        if(!Ajax::isAjax()){
            // a fresh page load starts the component from its own defaults
            self::forgetState($id);
            return;
        }

        if(!self::addresses($id)) return; // the request belongs to another bond

        // restore the state the component was left in, limited to its declared public properties
        $state = self::readState($id);

        foreach($class->bondProperties($class) as $prop => $default){
            if(array_key_exists($prop, $state)) $class->$prop = $state[$prop];
        }

        /* only the addressed bond sees the payload, so the fields of one component can no
           longer be written back onto another's inputs by matching name */
        self::$bondAjax[$id] = [
            'data'   => json_decode($_POST['data'] ?? '[]', true) ?: [],
            'action' => $_POST['action'] ?? '',
        ];

        $method = (string) ($_POST['call'] ?? '');

        if($method !== '' && self::isBondAction($class, $method)){
            Container::instance()->callMethod($class, $method);
        }

        $state = [];

        foreach($class->bondProperties($class) as $prop => $default){
            $state[$prop] = $class->$prop;
        }

        self::writeState($id, $state);

        $args = $state;

    }

    /**
     * Returns a bond's identity, which is stable across the renders of a page.
     *
     * The id used to be an incrementing counter, so a bond that was rendered conditionally
     * shifted the id of every bond after it and the stored state of one component was read
     * back into another. The identity is derived from the controller and its position among
     * the bonds of that same controller instead, or from $key where one is supplied.
     *
     * @param string $space bond controller space
     * @param string $key optional author supplied name
     * @return string
     */
    private static function bondIdentity(string $space, string $key = '') : string {

        static $counts = [];

        if($key === ''){
            $counts[$space] = ($counts[$space] ?? -1) + 1;
            $key = (string) $counts[$space];
        }

        return substr(hash('sha256', $space.'@'.$key), 0, 16);

    }

    /**
     * Determines whether the current request addresses the bond supplied.
     *
     * @param string $id bond identity
     * @return bool
     */
    private static function addresses(string $id) : bool {

        $sent = (string) ($_POST['bondId'] ?? '');

        if($sent === '' || !hash_equals($id, $sent)) return false;

        // the request must also carry the token that was written onto the rendered bond
        $token = (string) ($_POST['bondToken'] ?? '');

        return ($token !== '') && hash_equals(self::bondToken(), $token);

    }

    /**
     * Determines whether a method name received from a request may be called on a bond.
     *
     * The name arrives from the browser, so it is only honoured for a method the controller
     * declares itself. Anything inherited from this class (render, mount, resolve, the error
     * helpers) stays unreachable, as does anything static, magic or expecting arguments.
     *
     * @param BondComponent $class the bond the call was made on
     * @param string $method requested method name
     * @return bool
     */
    private static function isBondAction(BondComponent $class, string $method) : bool {

        if($method === '' || str_starts_with($method, '__')) return false;

        if(in_array(strtolower($method), self::reservedMethods(), true)) return false;

        if(!method_exists($class, $method)) return false;

        $reflection = new ReflectionMethod($class, $method);

        if(!$reflection->isPublic() || $reflection->isStatic()) return false;

        if($reflection->getNumberOfRequiredParameters() > 0) return false;

        $declaring = $reflection->getDeclaringClass()->getName();

        return !in_array($declaring, [self::class, Bond::class], true);

    }

    /**
     * Returns the lower cased names of every method this class and Bond provide.
     *
     * @return array
     */
    private static function reservedMethods() : array {

        static $reserved = null;

        if($reserved !== null) return $reserved;

        $reserved = [];

        foreach([self::class, Bond::class] as $base){
            foreach((new ReflectionClass($base))->getMethods() as $method){
                $reserved[] = strtolower($method->getName());
            }
        }

        return $reserved = array_values(array_unique($reserved));

    }

    /**
     * Returns the token a bond request is verified with, generating one where none exists.
     *
     * @return string
     */
    private static function bondToken() : string {

        $store = self::stateStore();

        $token = $store[self::TOKEN_KEY] ?? '';

        if(!is_string($token) || $token === ''){
            $token = bin2hex(random_bytes(16));
            $store[self::TOKEN_KEY] = $token;
            Session::base()->save(self::STATE_KEY, $store);
        }

        return $token;

    }

    /**
     * Returns every stored bond state belonging to the current visitor
     *
     * @return array
     */
    private static function stateStore() : array {

        $store = Session::base()->value(self::STATE_KEY);

        return is_array($store)? $store : [];

    }

    /**
     * Returns the stored state of a single bond
     *
     * @param string $id bond identity
     * @return array
     */
    private static function readState(string $id) : array {

        $state = self::stateStore()[$id]['props'] ?? [];

        return is_array($state)? $state : [];

    }

    /**
     * Stores the state of a single bond
     *
     * @param string $id bond identity
     * @param array $state the bond's public property values
     * @return void
     */
    private static function writeState(string $id, array $state) : void {

        $store = self::stateStore();

        $store[$id] = ['props' => $state, 'time' => time()];

        /* a visitor moving through a site would otherwise accumulate a state entry for every
           bond they ever loaded, so the least recently used entries are dropped */
        $states = array_filter($store, fn($key) => $key !== self::TOKEN_KEY, ARRAY_FILTER_USE_KEY);

        if(count($states) > self::STATE_LIMIT){
            uasort($states, fn($a, $b) => ($b['time'] ?? 0) <=> ($a['time'] ?? 0));
            $states = array_slice($states, 0, self::STATE_LIMIT, true);
            $states[self::TOKEN_KEY] = $store[self::TOKEN_KEY] ?? '';
            $store = $states;
        }

        Session::base()->save(self::STATE_KEY, $store);

    }

    /**
     * Discards the stored state of a single bond
     *
     * @param string $id bond identity
     * @return void
     */
    private static function forgetState(string $id) : void {

        $store = self::stateStore();

        if(!array_key_exists($id, $store)) return;

        unset($store[$id]);

        Session::base()->save(self::STATE_KEY, $store);

    }


    /**
     * Return only public properties of a class
     *
     * @param object $class
     * @return array
     */
    final public function bondProperties(object $class) : array {

        $props = [];

        foreach((new ReflectionClass($class))->getProperties(ReflectionProperty::IS_PUBLIC) as $property){

            if($property->isStatic()) continue;

            /* the live value is read from the instance rather than the class defaults, so a
               property first given a value in mount() is carried like any other. A typed
               property that has not been given one yet has no value to read at all. */
            if(!$property->isInitialized($class)) continue;

            $props[$property->getName()] = $property->getValue($class);

        }

        return $props;

    }

    final static public function postdata() : array {
        return fromJson((new Request())->prompt('postdata')) ?? [];
    }

}

