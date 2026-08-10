<?php 

namespace spoova\mi\core\classes;

use ReflectionClass;
use ReflectionProperty;
use spoova\mi\core\classes\Container\Container;
use Dom\HTMLDocument;
use Dom\Element;

abstract class BondComponent{ 

    private static $body = '';
    private static $bondAjax = [];
    private static BondComponent $instance;
    protected $bondID;

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
     * @param string $space Bond controller space within windows\Bond environment
     * @param array $args
     * @return string
     */
    final public function resolve($space, array $args = []) : string {
        static $id = 0; $id++;
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

                    $bondArgs = $this->bondArguments('data');

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
     * @param int $id incrementing id, also written to the bond:root attribute
     * @return void
     */
    final public function setBond(int $id){
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
     * @return int
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

        return self::$bondAjax[$key] ?? [];

    }

    private function bindAjax(Bond $class, $id, &$args) {
        
        $bondName = 'bondJS';

        $cookie = $_COOKIE[$bondName] ?? '';

        $fulldata = (json_decode($cookie,true));
        
        $data = $fulldata[$class->bondID()] ?? [];

        if(Ajax::isAjax()){

            $post = $_POST;

            // $action = $_POST['postdata'] ?? '[]';
            // $action = json_decode($action, true) ?? [];
            // $action = $post['action'];

            $bondData = $post['data'] ?? '[]';
            $bondData = json_decode($bondData, true) ?? [];
            self::$bondAjax['data'] = $bondData;

            self::$bondAjax['action'] = $post['action'] ?? '';

            $method = $post['call'];

            foreach($data as $oldprop => $val) {
                $class->$oldprop = $val;
            }

            $class->$method();

            $props = $class->bondProperties($class);

            foreach($props as $prop => $value) {
                $data[$prop] = $class->$prop;
            }
            
            $fulldata[$class->bondID()] = $args = $data;

            setcookie($bondName, json_encode($fulldata), [
                "secure" => true,
                'samesite' => "None",
                'httponly' => true,
            ]);

        } else {

            setcookie($bondName, '[]', [
                'expires'  => -36000,
                'secure'   => true,
                'samesite' => "None"
            ]);

        }

    }


    /**
     * Return only public properties of a class
     *
     * @param object $class
     * @return array
     */
    final public function bondProperties(object $class) : array {

        $vars = get_class_vars($class::class);

        $rc = new ReflectionClass($class);
        $propLists = $rc->getProperties(ReflectionProperty::IS_PUBLIC);
        $props = [];
        foreach($propLists as $propList){
            $props[] = $propList->getName();
        }
        
        $publics = (array_intersect_key($vars, array_flip($props)));

        return $publics;

    }

    final static public function postdata() : array {
        return fromJson((new Request())->prompt('postdata')) ?? [];
    }

}

