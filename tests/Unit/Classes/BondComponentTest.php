<?php

namespace spoova\mi\tests\Unit\Classes;

use Dom\HTMLDocument;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use spoova\mi\core\classes\BondComponent;

/**
 * Covers the parts of BondComponent that decide what a bond request is allowed to do and
 * how a rendered component is prepared: the identity a bond is addressed by, the methods a
 * request may name, the root element a component is mounted on, and how a submitted value
 * is written back onto a field.
 *
 * These are the pieces that hold without a session, a database or a rendered page. The
 * round trip itself (state restore, method call, state save) is exercised against a running
 * application rather than here.
 */
class BondComponentTest extends TestCase
{
    /** Calls a private static method of BondComponent. */
    private static function call(string $method, array $args = [])
    {
        $reflection = new ReflectionMethod(BondComponent::class, $method);
        $reflection->setAccessible(true);

        return $reflection->invokeArgs(null, $args);
    }

    /* ---- identity ---- */

    public function test_the_same_controller_gets_a_different_identity_per_occurrence(): void
    {
        $first  = self::call('bondIdentity', ['Counter']);
        $second = self::call('bondIdentity', ['Counter']);

        $this->assertNotSame($first, $second, 'two bonds of one controller must not share a state entry');
    }

    public function test_a_supplied_key_identifies_a_bond_regardless_of_render_order(): void
    {
        $first  = self::call('bondIdentity', ['Counter', 'sidebar']);
        $second = self::call('bondIdentity', ['Counter', 'sidebar']);

        $this->assertSame($first, $second, 'a keyed bond keeps its identity across renders');
    }

    public function test_identity_separates_controllers(): void
    {
        $this->assertNotSame(
            self::call('bondIdentity', ['Counter', 'x']),
            self::call('bondIdentity', ['Basket', 'x'])
        );
    }

    /* ---- which methods a request may name ---- */

    public function test_a_method_the_controller_declares_may_be_called(): void
    {
        $this->assertTrue(self::call('isBondAction', [new BondActionsDouble, 'increment']));
    }

    public function test_a_method_inherited_from_the_base_may_not_be_called(): void
    {
        // reachable on the instance, but never part of a component's own interface
        foreach (['clearErrors', 'addError', 'resolve', 'setBond', 'bondProperties', 'mount'] as $method) {
            $this->assertFalse(
                self::call('isBondAction', [new BondActionsDouble, $method]),
                $method.'() must not be reachable from a request'
            );
        }
    }

    public function test_a_redeclared_base_method_may_not_be_called(): void
    {
        // render() is declared on the double itself, so only the reserved list keeps it out
        $this->assertFalse(self::call('isBondAction', [new BondActionsDouble, 'render']));
    }

    public function test_protected_static_magic_and_unknown_methods_may_not_be_called(): void
    {
        $double = new BondActionsDouble;

        $this->assertFalse(self::call('isBondAction', [$double, 'hidden']),   'protected');
        $this->assertFalse(self::call('isBondAction', [$double, 'shared']),   'static');
        $this->assertFalse(self::call('isBondAction', [$double, '__invoke']), 'magic');
        $this->assertFalse(self::call('isBondAction', [$double, 'missing']),  'undefined');
        $this->assertFalse(self::call('isBondAction', [$double, '']),         'empty');
    }

    public function test_a_method_expecting_arguments_may_not_be_called(): void
    {
        // a request supplies no arguments, so calling it would be a type error
        $this->assertFalse(self::call('isBondAction', [new BondActionsDouble, 'needsArgument']));
    }

    /* ---- the element a component is mounted on ---- */

    public function test_a_single_element_component_is_its_own_root(): void
    {
        $root = self::call('bondRoot', [self::dom('<div id="only"><span>hi</span></div>')]);

        $this->assertSame('only', $root->getAttribute('id'));
        $this->assertFalse($root->hasAttribute('bond:wrap'));
    }

    public function test_side_by_side_elements_are_wrapped_so_the_component_stays_addressable(): void
    {
        $root = self::call('bondRoot', [self::dom('<p>one</p>text<p>two</p>')]);

        $this->assertSame('true', $root->getAttribute('bond:wrap'));
        $this->assertStringContainsString('one', $root->textContent);
        $this->assertStringContainsString('text', $root->textContent, 'text between elements keeps its place');
        $this->assertStringContainsString('two', $root->textContent);
    }

    public function test_a_component_that_renders_no_element_has_no_root(): void
    {
        $this->assertNull(self::call('bondRoot', [self::dom('   ')]));
    }

    /* ---- writing a submitted value back onto a field ---- */

    public function test_a_text_input_is_given_the_submitted_value(): void
    {
        $field = self::field('<input type="text" name="title" value="old">');

        self::call('setFieldValue', [$field, ['name' => 'title', 'value' => 'new']]);

        $this->assertSame('new', $field->getAttribute('value'));
    }

    public function test_a_textarea_carries_its_value_as_content(): void
    {
        $field = self::field('<textarea name="body">old</textarea>');

        self::call('setFieldValue', [$field, ['name' => 'body', 'value' => 'new']]);

        $this->assertSame('new', $field->textContent);
    }

    public function test_a_select_marks_the_submitted_option(): void
    {
        $field = self::field('<select name="pick"><option value="a" selected>A</option><option value="b">B</option></select>');

        self::call('setFieldValue', [$field, ['name' => 'pick', 'value' => 'b']]);

        $options = $field->getElementsByTagName('option');

        $this->assertFalse($options[0]->hasAttribute('selected'));
        $this->assertTrue($options[1]->hasAttribute('selected'));
    }

    public function test_a_checkbox_follows_the_reported_state_and_keeps_its_value(): void
    {
        $field = self::field('<input type="checkbox" name="agree" value="yes">');

        self::call('setFieldValue', [$field, ['name' => 'agree', 'value' => 'yes', 'checked' => true]]);
        $this->assertTrue($field->hasAttribute('checked'));
        $this->assertSame('yes', $field->getAttribute('value'), 'value is what the field submits and must survive');

        self::call('setFieldValue', [$field, ['name' => 'agree', 'value' => 'yes', 'checked' => false]]);
        $this->assertFalse($field->hasAttribute('checked'));
    }

    public function test_a_checkbox_is_left_alone_when_no_state_was_reported(): void
    {
        // a payload from an older client carries no checked key
        $field = self::field('<input type="checkbox" name="agree" value="yes" checked>');

        self::call('setFieldValue', [$field, ['name' => 'agree', 'value' => 'yes']]);

        $this->assertTrue($field->hasAttribute('checked'));
    }

    /* ---- helpers ---- */

    private static function dom(string $html): HTMLDocument
    {
        return HTMLDocument::createFromString($html, LIBXML_NOERROR, 'UTF-8');
    }

    /** Returns the first element of a rendered fragment. */
    private static function field(string $html)
    {
        return self::dom($html)->body->firstElementChild;
    }
}

/**
 * Stands in for a bond controller. It is not a BondComponent subclass by accident: the
 * whitelist has to answer for every method reachable on a real component, including the
 * ones this class inherits.
 */
class BondActionsDouble extends BondComponent
{
    public $count = 0;

    public function increment() { $this->count++; }

    public function needsArgument(string $value) { return $value; }

    public function render(): \spoova\mi\core\classes\Compiler|string { return ''; }

    public function mount() {}

    public function __invoke() {}

    public static function shared() {}

    protected function hidden() {}
}
