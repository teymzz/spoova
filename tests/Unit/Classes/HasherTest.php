<?php

namespace spoova\mi\tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use spoova\mi\core\classes\Hasher;

/**
 * Covers Hasher, which turns a set of credentials into a signed hash string and
 * generates standalone random keys.
 *
 * The exact digest is an implementation detail and is deliberately never asserted
 * — what a caller depends on is that it is reproducible for the same inputs and
 * that it moves when any input moves.
 */
class HasherTest extends TestCase
{
    /* ---- what gets hashed ---- */

    /**
     * Hashing is only set up for a set of credentials. A bare scalar is stored but
     * cannot be signed, and callers branch on the FALSE, so it must not become an
     * empty string or a hash of nothing.
     */
    public function test_a_non_array_credential_cannot_be_hashed(): void
    {
        $hasher = new Hasher('plain-string', 'key');

        $this->assertFalse($hasher->hashify());
    }

    public function test_credentials_are_read_back_as_an_array(): void
    {
        $this->assertSame(['abc'], (new Hasher('abc'))->data());
        $this->assertSame(['user' => 'joe'], (new Hasher(['user' => 'joe']))->data());
    }

    public function test_nothing_is_hashed_until_credentials_are_set(): void
    {
        $hasher = new Hasher();

        $this->assertFalse($hasher->hashify());

        $hasher->setHash(['user' => 'joe'], 'key');

        $this->assertIsString($hasher->hashify());
    }

    /**
     * setHash() replaces the credentials rather than adding to them, so a hasher
     * reused across two requests must not sign the first request's data.
     */
    public function test_setting_new_credentials_replaces_the_previous_ones(): void
    {
        $reused = new Hasher(['user' => 'joe'], 'key');
        $reused->hashify();
        $reused->setHash(['user' => 'ann'], 'key');

        $fresh = new Hasher(['user' => 'ann'], 'key');

        $this->assertSame($fresh->hashify(), $reused->hashify(0));
    }

    /**
     * The key is optional. md5() has not accepted NULL since PHP 8.1, so an unkeyed
     * hasher used to sign its credentials and raise a deprecation on the way.
     */
    public function test_credentials_can_be_hashed_without_a_key(): void
    {
        $raised = [];

        set_error_handler(function (int $type, string $message) use (&$raised) {
            $raised[] = $message;
            return true;
        }, E_DEPRECATED);

        try {
            $hash = (new Hasher(['user' => 'joe']))->hashify();
        } finally {
            restore_error_handler();
        }

        $this->assertSame([], $raised, 'Hashing without a key should raise nothing.');
        $this->assertSame(40, strlen($hash));
    }

    /**
     * An absent key and an empty one are the same absence of a key — they must not
     * become two different signatures over the same credentials.
     */
    public function test_no_key_signs_the_same_way_as_an_empty_key(): void
    {
        $unkeyed = (new Hasher(['user' => 'joe']))->hashify();
        $empty   = (new Hasher(['user' => 'joe'], ''))->hashify();

        $this->assertSame($unkeyed, $empty);
    }

    /* ---- reproducibility ---- */

    public function test_the_same_credentials_and_key_hash_the_same_way(): void
    {
        $first  = new Hasher(['user' => 'joe', 'role' => 'admin'], 'key');
        $second = new Hasher(['user' => 'joe', 'role' => 'admin'], 'key');

        $this->assertSame($first->hashify(), $second->hashify());
    }

    public function test_a_different_key_produces_a_different_hash(): void
    {
        $signed = (new Hasher(['user' => 'joe'], 'key'))->hashify();
        $forged = (new Hasher(['user' => 'joe'], 'other-key'))->hashify();

        $this->assertNotSame($signed, $forged, 'The key must take part in the digest.');
    }

    public function test_a_different_credential_produces_a_different_hash(): void
    {
        $joe = (new Hasher(['user' => 'joe'], 'key'))->hashify();
        $ann = (new Hasher(['user' => 'ann'], 'key'))->hashify();

        $this->assertNotSame($joe, $ann);
    }

    /**
     * The credentials are concatenated before signing, so two different sets that
     * happen to join into the same string would collide unless the keys separate them.
     */
    public function test_credentials_that_concatenate_alike_do_not_collide(): void
    {
        $split  = (new Hasher(['a' => 'foo', 'b' => 'bar'], 'key'))->hashify();
        $joined = (new Hasher(['a' => 'foobar'], 'key'))->hashify();

        $this->assertNotSame($split, $joined);
    }

    /* ---- the hash chain ---- */

    /**
     * Each call advances an internal counter, so hashify() is a chain rather than a
     * pure function — the second call on one instance is a *new* hash, not a repeat
     * of the first. A caller that wants the signature back has to rewind.
     */
    public function test_hashing_twice_on_one_instance_advances_the_chain(): void
    {
        $hasher = new Hasher(['user' => 'joe'], 'key');

        $this->assertNotSame($hasher->hashify(), $hasher->hashify());
    }

    public function test_a_zero_rewinds_the_chain_to_the_first_hash(): void
    {
        $hasher = new Hasher(['user' => 'joe'], 'key');

        $first = $hasher->hashify();
        $hasher->hashify();
        $hasher->hashify();

        $this->assertSame($first, $hasher->hashify(0));
    }

    public function test_a_repeat_count_is_reproducible(): void
    {
        $first  = (new Hasher(['user' => 'joe'], 'key'))->hashify(3);
        $second = (new Hasher(['user' => 'joe'], 'key'))->hashify(3);

        $this->assertSame($first, $second);
        $this->assertNotSame($first, (new Hasher(['user' => 'joe'], 'key'))->hashify(4));
    }

    /* ---- salting algorithms ---- */

    public function test_the_digest_is_sha1_unless_another_algorithm_is_asked_for(): void
    {
        $hash = (new Hasher(['user' => 'joe'], 'key'))->hashify();

        $this->assertSame(40, strlen($hash));
        $this->assertTrue(ctype_xdigit($hash));
    }

    public function test_an_inline_algorithm_is_applied_to_the_result(): void
    {
        $hash = (new Hasher(['user' => 'joe'], 'key'))->hashify('md5');

        $this->assertSame(32, strlen($hash), 'md5 should have had the last word on the digest.');
        $this->assertTrue(ctype_xdigit($hash));
    }

    /**
     * Both lists end in sha1, so they agree on length — only the order of the
     * algorithms can separate the two digests.
     */
    public function test_algorithms_are_applied_in_the_order_given(): void
    {
        $mixed  = (new Hasher(['user' => 'joe'], 'key'))->hashify(['md5', 'sha1']);
        $doubled = (new Hasher(['user' => 'joe'], 'key'))->hashify(['sha1', 'sha1']);

        $this->assertSame(40, strlen($mixed));
        $this->assertSame(40, strlen($doubled));
        $this->assertNotSame($mixed, $doubled);
    }

    /**
     * hashFunc() reports rather than throws, and a rejected list must not be half
     * applied — one unknown name has to leave the previous list untouched.
     */
    public function test_an_unknown_algorithm_is_rejected(): void
    {
        $hasher = new Hasher(['user' => 'joe'], 'key');

        $this->assertTrue($hasher->hashFunc(['md5', 'sha1']));
        $this->assertFalse($hasher->hashFunc(['md5', 'no_such_hash_function']));
    }

    public function test_a_configured_algorithm_list_is_used_for_every_hash(): void
    {
        $configured = new Hasher(['user' => 'joe'], 'key');
        $configured->hashFunc('md5');

        $plain = new Hasher(['user' => 'joe'], 'key');

        $this->assertNotSame($plain->hashify(), $configured->hashify());
        $this->assertSame(32, strlen($configured->hashify(0)));
    }

    /* ---- randomization ---- */

    public function test_randomizing_moves_the_hash_away_from_the_plain_one(): void
    {
        $plain = (new Hasher(['user' => 'joe'], 'key'))->hashify();

        $randomized = new Hasher(['user' => 'joe'], 'key');
        $randomized->randomize('SALT');

        $this->assertNotSame($plain, $randomized->hashify());
    }

    /**
     * A caller supplying its own random value is asking for a hash it can rebuild
     * later — an explicit seed has to behave like part of the credentials, not like time().
     */
    public function test_an_explicit_random_value_is_reproducible(): void
    {
        $first  = new Hasher(['user' => 'joe'], 'key');
        $second = new Hasher(['user' => 'joe'], 'key');
        $first->randomize('SALT');
        $second->randomize('SALT');

        $this->assertSame($first->hashify(), $second->hashify());
    }

    public function test_different_random_values_produce_different_hashes(): void
    {
        $first  = new Hasher(['user' => 'joe'], 'key');
        $second = new Hasher(['user' => 'joe'], 'key');
        $first->randomize('SALT-A');
        $second->randomize('SALT-B');

        $this->assertNotSame($first->hashify(), $second->hashify());
    }

    public function test_randomization_can_be_switched_back_off(): void
    {
        $hasher = new Hasher(['user' => 'joe'], 'key');
        $hasher->randomize('SALT');
        $hasher->randomize(false);

        $plain = new Hasher(['user' => 'joe'], 'key');

        $this->assertSame($plain->hashify(), $hasher->hashify());
    }

    /* ---- standalone random keys ---- */

    public function test_a_random_hash_defaults_to_six_characters(): void
    {
        $this->assertSame(6, strlen((new Hasher())->randomHash()));
    }

    public function test_a_random_hash_honours_the_length_asked_for(): void
    {
        $this->assertSame(20, strlen((new Hasher())->randomHash(20)));
    }

    public function test_random_hashes_do_not_repeat(): void
    {
        $hasher = new Hasher();

        $keys = [];
        for ($i = 0; $i < 50; $i++) {
            $keys[] = $hasher->randomHash(16);
        }

        $this->assertCount(50, array_unique($keys), 'Random keys collided.');
    }

    public function test_a_random_hash_draws_only_from_the_keyspace_given(): void
    {
        $key = (new Hasher())->randomHash(30, 'ab');

        $this->assertSame(30, strlen($key));
        $this->assertMatchesRegularExpression('/^[ab]+$/', $key);
    }

    public function test_a_random_hash_can_be_run_through_an_algorithm(): void
    {
        $key = (new Hasher())->randomHash(8, null, 'md5');

        $this->assertSame(32, strlen($key));
        $this->assertTrue(ctype_xdigit($key));
    }

    /**
     * An unknown algorithm cannot produce a key, and the empty string is how that
     * failure reaches the caller — a caller must never mistake it for a usable key.
     */
    public function test_a_random_hash_with_an_unknown_algorithm_yields_nothing(): void
    {
        $this->assertSame('', (new Hasher())->randomHash(8, null, 'no_such_hash_function'));
    }
}
