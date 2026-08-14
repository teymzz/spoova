<?php

namespace spoova\mi\tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use spoova\mi\core\classes\Lqip;

/**
 * Covers Lqip, which scales an image down to a handful of pixels and returns it
 * as an inlinable data URI.
 */
class LqipTest extends TestCase
{
    /** Images written for a test, removed afterwards. */
    private array $files = [];

    /** Cache directory used for the duration of a test. */
    private string $cacheDir;

    private string $originalCacheDir;

    protected function setUp(): void
    {
        if (!extension_loaded('gd')) {
            $this->markTestSkipped('GD is needed to generate placeholders.');
        }

        $this->originalCacheDir = Lqip::$cacheDir;

        // a cache of its own, so a test never reads a placeholder the project built
        $this->cacheDir = 'core/storage/lqip-test-'.uniqid();
        Lqip::$cacheDir = $this->cacheDir;
    }

    protected function tearDown(): void
    {
        if (isset($this->cacheDir) && is_dir($directory = Lqip::directory())) {
            foreach (glob($directory.DIRECTORY_SEPARATOR.'*') ?: [] as $file) {
                unlink($file);
            }
            rmdir($directory);
        }

        Lqip::$cacheDir = $this->originalCacheDir;

        foreach ($this->files as $file) {
            if (is_file($file)) unlink($file);
        }

        $this->files = [];
    }

    /**
     * Writes a real image of the given size and returns its path.
     */
    private function image(int $width, int $height, string $format = 'jpeg'): string
    {
        $file = sys_get_temp_dir().DIRECTORY_SEPARATOR.'spoova-lqip-'.uniqid().'.'.$format;

        $canvas = imagecreatetruecolor($width, $height);

        // some actual content, so a resample has something to average
        imagefilledrectangle($canvas, 0, 0, $width, $height, imagecolorallocate($canvas, 200, 30, 30));
        imagefilledrectangle($canvas, 0, 0, (int) ($width / 2), $height, imagecolorallocate($canvas, 20, 40, 200));

        if ($format === 'png') {
            imagepng($canvas, $file);
        } else {
            imagejpeg($canvas, $file);
        }

        imagedestroy($canvas);

        return $this->files[] = $file;
    }

    /** Decodes a data URI back to its binary payload. */
    private function decode(string $uri): string
    {
        $comma = strpos($uri, ',');

        return base64_decode(substr($uri, $comma + 1));
    }

    /* ---- generating ---- */

    public function test_an_image_becomes_a_base64_data_uri(): void
    {
        $uri = Lqip::uri($this->image(400, 300));

        $this->assertStringStartsWith('data:image/jpeg;base64,', $uri);
        $this->assertNotSame('', $this->decode($uri));
    }

    /**
     * The placeholder travels inside the HTML, so its size is the whole cost of the
     * technique — a placeholder as heavy as a real thumbnail is not worth inlining.
     */
    public function test_a_placeholder_is_small_enough_to_inline(): void
    {
        $uri = Lqip::uri($this->image(1600, 1200));

        $this->assertLessThan(2048, strlen($uri), 'The data URI is too heavy to inline.');
    }

    public function test_a_placeholder_is_scaled_to_the_width_asked_for(): void
    {
        $uri = Lqip::uri($this->image(400, 300), 32);

        [$width] = getimagesizefromstring($this->decode($uri));

        $this->assertSame(32, $width);
    }

    /**
     * A stretched placeholder behind a correctly proportioned image shows as a
     * smear at one edge, so the ratio has to survive the scaling.
     */
    public function test_the_aspect_ratio_is_kept(): void
    {
        $uri = Lqip::uri($this->image(400, 100), 20);

        [$width, $height] = getimagesizefromstring($this->decode($uri));

        $this->assertSame(20, $width);
        $this->assertSame(5, $height);
    }

    /**
     * Rounding a very wide, very short image down can reach zero, and an image of
     * no height cannot be created at all.
     */
    public function test_an_extremely_wide_image_still_has_a_row_of_pixels(): void
    {
        $uri = Lqip::uri($this->image(2000, 10), 16);

        [, $height] = getimagesizefromstring($this->decode($uri));

        $this->assertGreaterThanOrEqual(1, $height);
    }

    public function test_an_image_smaller_than_the_placeholder_is_not_scaled_up(): void
    {
        $uri = Lqip::uri($this->image(10, 10), 24);

        [$width] = getimagesizefromstring($this->decode($uri));

        $this->assertSame(10, $width, 'Scaling up only adds bytes for no detail.');
    }

    /**
     * A transparent source drawn onto an opaque canvas comes back with black behind
     * it, which is far more obvious blurred and scaled up than it is at full size.
     */
    public function test_a_png_keeps_its_transparency(): void
    {
        $file = sys_get_temp_dir().DIRECTORY_SEPARATOR.'spoova-lqip-'.uniqid().'.png';
        $this->files[] = $file;

        $canvas = imagecreatetruecolor(100, 100);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        imagefill($canvas, 0, 0, imagecolorallocatealpha($canvas, 0, 0, 0, 127));
        imagepng($canvas, $file);
        imagedestroy($canvas);

        $uri = Lqip::uri($file);

        $this->assertStringStartsWith('data:image/png;base64,', $uri, 'An alpha source must not be flattened to JPEG.');

        $thumb = imagecreatefromstring($this->decode($uri));
        $colour = imagecolorsforindex($thumb, imagecolorat($thumb, 0, 0));

        $this->assertSame(127, $colour['alpha'], 'The transparent corner came back opaque.');
    }

    /* ---- images that cannot be read ---- */

    /**
     * A placeholder is a visual nicety. Nothing about a missing or unreadable file
     * should reach the page as an error — the caller renders without one.
     */
    public function test_a_missing_file_yields_no_placeholder(): void
    {
        $this->assertSame('', Lqip::uri(sys_get_temp_dir().'/does-not-exist-'.uniqid().'.jpg'));
    }

    public function test_a_file_that_is_not_an_image_yields_no_placeholder(): void
    {
        $file = sys_get_temp_dir().DIRECTORY_SEPARATOR.'spoova-lqip-'.uniqid().'.jpg';
        file_put_contents($file, 'this is not an image');
        $this->files[] = $file;

        $this->assertSame('', Lqip::uri($file));
    }

    public function test_a_directory_yields_no_placeholder(): void
    {
        $this->assertSame('', Lqip::uri(sys_get_temp_dir()));
    }

    /* ---- locating an image ---- */

    /** Absolute path of a project-relative one, in the form locate() returns. */
    private function rooted(string $relative): string
    {
        return rtrim(docroot, '\\/').DIRECTORY_SEPARATOR
             . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    }

    public function test_a_prefix_names_the_root_outright(): void
    {
        $this->assertSame($this->rooted('res/main/images/a.png'), Lqip::locate('main:images/a.png'));
        $this->assertSame($this->rooted('res/assets/images/a.png'), Lqip::locate('assets:images/a.png'));
        $this->assertSame($this->rooted('res/images/a.png'), Lqip::locate('res:images/a.png'));
    }

    /**
     * A prefixed path names its root outright, so it must resolve there whether or
     * not the file exists — otherwise a typo silently resolves somewhere else.
     */
    public function test_a_prefixed_path_does_not_fall_back_to_another_root(): void
    {
        $this->assertSame(
            $this->rooted('res/assets/images/not-here.png'),
            Lqip::locate('assets:images/not-here.png')
        );
    }

    /**
     * domUrl() tracks paths already relative to the project root, which is the form
     * a bare @lqip() receives.
     */
    public function test_a_path_relative_to_the_project_root_is_taken_as_it_stands(): void
    {
        $this->assertSame(
            $this->rooted('res/main/images/404.png'),
            Lqip::locate('res/main/images/404.png')
        );
    }

    public function test_a_bare_path_is_resolved_against_the_resource_roots(): void
    {
        // res/main/images/404.png ships with the framework
        $this->assertSame($this->rooted('res/main/images/404.png'), Lqip::locate('images/404.png'));
    }

    public function test_a_leading_slash_makes_no_difference(): void
    {
        $this->assertSame(Lqip::locate('images/404.png'), Lqip::locate('/images/404.png'));
    }

    public function test_backslashes_are_read_as_separators(): void
    {
        $this->assertSame(
            $this->rooted('res/main/images/404.png'),
            Lqip::locate('res\\main\\images\\404.png')
        );
    }

    /**
     * @mapp and friends return full urls, so a caller passing one back — or reading
     * one out of existing markup — should not have to strip it first.
     */
    public function test_a_url_is_reduced_to_the_path_inside_it(): void
    {
        $this->assertSame(
            $this->rooted('res/main/images/404.png'),
            Lqip::locate('http://localhost/'.docBase.'/res/main/images/404.png')
        );
    }

    public function test_an_empty_path_locates_nothing(): void
    {
        $this->assertSame('', Lqip::locate(''));
        $this->assertSame('', Lqip::locate('   '));
    }

    /**
     * A path that matches no root still has to come back as a path, so that uri()
     * is the single place a missing image is reported.
     */
    public function test_an_unknown_path_is_reported_against_the_project_root(): void
    {
        $this->assertSame($this->rooted('nowhere/a.png'), Lqip::locate('nowhere/a.png'));
        $this->assertSame('', Lqip::uri(Lqip::locate('nowhere/a.png')));
    }

    /* ---- caching ---- */

    public function test_a_placeholder_is_cached_on_disk(): void
    {
        $file = $this->image(400, 300);

        $first = Lqip::uri($file);

        $this->assertCount(1, glob(Lqip::directory().DIRECTORY_SEPARATOR.'*.txt'));
        $this->assertSame($first, Lqip::uri($file));
    }

    /**
     * The cache is keyed by modification time, so replacing an image has to produce
     * a new placeholder — a stale one would outlive the image it stands for.
     */
    public function test_editing_an_image_invalidates_its_placeholder(): void
    {
        $file = $this->image(400, 300);
        $first = Lqip::uri($file);

        // a different picture at the same path, with a later mtime
        $canvas = imagecreatetruecolor(400, 300);
        imagefilledrectangle($canvas, 0, 0, 400, 300, imagecolorallocate($canvas, 10, 200, 10));
        imagejpeg($canvas, $file);
        imagedestroy($canvas);
        touch($file, time() + 10);
        clearstatcache();

        $this->assertNotSame($first, Lqip::uri($file));
    }

    public function test_different_widths_are_cached_apart(): void
    {
        $file = $this->image(400, 300);

        $narrow = Lqip::uri($file, 16);
        $wide   = Lqip::uri($file, 40);

        $this->assertNotSame($narrow, $wide);
        $this->assertCount(2, glob(Lqip::directory().DIRECTORY_SEPARATOR.'*.txt'));
    }

    public function test_clearing_empties_the_cache(): void
    {
        Lqip::uri($this->image(400, 300));

        $this->assertSame(1, Lqip::clear());
        $this->assertSame([], glob(Lqip::directory().DIRECTORY_SEPARATOR.'*.txt'));
    }

    /**
     * Nothing is cached for an image that produced no placeholder, or the failure
     * is what gets served once the image is fixed.
     */
    public function test_a_failure_is_not_cached(): void
    {
        Lqip::uri(sys_get_temp_dir().'/does-not-exist-'.uniqid().'.jpg');

        $this->assertSame([], glob(Lqip::directory().DIRECTORY_SEPARATOR.'*.txt') ?: []);
    }
}
