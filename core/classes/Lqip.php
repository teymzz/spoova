<?php

namespace spoova\mi\core\classes;

/**
 * Generates Low Quality Image Placeholders (LQIP).
 *
 * An LQIP is a very small copy of an image — a couple of dozen pixels wide —
 * returned as a base64 data URI so it travels inside the HTML rather than as a
 * second request. Scaled back up and blurred by CSS it stands in for the real
 * image while that one downloads, which is what gives the "blur up" effect.
 *
 * Placeholders are cached on disk and keyed by the source file's modification
 * time, so editing an image invalidates its placeholder without a manual purge.
 *
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class Lqip {

    /**
     * Width, in pixels, of a generated placeholder.
     *
     * Small enough that the data URI stays under a kilobyte or so — past roughly
     * 40px the URI costs more bytes than the effect is worth, and the blur throws
     * the extra detail away in any case.
     *
     * @var int
     */
    public static int $width = 24;

    /**
     * JPEG quality of a generated placeholder. It is about to be blurred, so the
     * artefacts a low setting introduces never reach the eye.
     *
     * @var int
     */
    public static int $quality = 40;

    /**
     * Directory holding cached placeholders, relative to the project root.
     *
     * @var string
     */
    public static string $cacheDir = 'core/storage/lqip';

    /**
     * Placeholders already generated this request, keyed by cache key.
     *
     * @var array
     */
    private static array $memo = [];

    /**
     * Image types GD can be asked to read here.
     *
     * @var array
     */
    private const readers = [
        IMAGETYPE_JPEG => 'imagecreatefromjpeg',
        IMAGETYPE_PNG  => 'imagecreatefrompng',
        IMAGETYPE_GIF  => 'imagecreatefromgif',
        IMAGETYPE_WEBP => 'imagecreatefromwebp',
    ];

    /**
     * Directory prefixes a caller may use in place of a full path, matching the
     * directives that resolve the same roots — @mapp for res/main, @mass for
     * res/assets, @src / @ress for res.
     *
     * @var array
     */
    private const prefixes = [
        'main:'   => 'res/main/',
        'assets:' => 'res/assets/',
        'res:'    => 'res/',
    ];

    /**
     * Roots searched, in order, for a path given without a prefix.
     *
     * res/main comes first because it is where @mapp looks and where images
     * overwhelmingly live; the project root comes first of all so that a path
     * already written out in full is taken at its word.
     *
     * @var array
     */
    private const roots = ['', 'res/main/', 'res/assets/', 'res/'];

    /**
     * Resolve a path as written in a template to an absolute filesystem path.
     *
     * Accepts what any of the resource directives accept: a path already relative
     * to the project root (as {@see \domUrl()} tracks it), a "main:" / "assets:" /
     * "res:" prefixed path, a bare path resolved against the roots above, or a
     * full http url pointing back at this project.
     *
     * @param string $path path as written in a template, or as tracked by domUrl()
     * @return string absolute filesystem path, or an empty string if $path is empty.
     *   The path is not required to exist — {@see self::uri()} reports that.
     */
    public static function locate(string $path) : string {

        $path = trim($path);

        if($path === '') return '';

        // a url rather than a path: keep what follows the host and resolve that
        if(preg_match('~^https?://[^/]+/(.*)$~i', $path, $matched)){
            $path = $matched[1];

            // on localhost the project sits a directory deep, so drop that segment
            if(defined('docBase') && strpos($path, docBase.'/') === 0){
                $path = substr($path, strlen(docBase) + 1);
            }
        }

        $path = ltrim(str_replace('\\', '/', $path), '/');

        foreach(self::prefixes as $prefix => $root){
            if(stripos($path, $prefix) === 0){
                return self::absolute($root.ltrim(substr($path, strlen($prefix)), '/'));
            }
        }

        foreach(self::roots as $root){
            $candidate = self::absolute($root.$path);
            if(is_file($candidate)) return $candidate;
        }

        // nothing matched; report it against the project root
        return self::absolute($path);

    }

    /**
     * Turn a project-relative path into an absolute one.
     *
     * @param string $path project-relative path
     * @return string
     */
    private static function absolute(string $path) : string {
        $root = defined('docroot') ? docroot : dirname(__DIR__, 3);

        return rtrim($root, '\\/').DIRECTORY_SEPARATOR
             . str_replace('/', DIRECTORY_SEPARATOR, ltrim($path, '/'));
    }

    /**
     * Build (or fetch) the placeholder for an image and return it as a data URI.
     *
     * @param string $path absolute path of the source image
     * @param int|null $width width of the placeholder, defaulting to {@see self::$width}
     * @return string a "data:image/..;base64,.." URI, or an empty string if no
     *   placeholder could be made. Callers treat the empty string as "no
     *   placeholder" and fall back to whatever they show without one — a missing
     *   or unreadable image must never take a page down over a visual nicety.
     */
    public static function uri(string $path, ?int $width = null) : string {

        $width = $width ?? self::$width;

        if(!is_file($path) || !is_readable($path)) return '';

        $key = self::key($path, $width);

        if(isset(self::$memo[$key])) return self::$memo[$key];

        $cached = self::cachePath($key);

        if(is_file($cached)){
            return self::$memo[$key] = (string) file_get_contents($cached);
        }

        $uri = self::generate($path, $width);

        if($uri !== '') self::store($cached, $uri);

        return self::$memo[$key] = $uri;

    }

    /**
     * Scale an image down and encode it as a data URI.
     *
     * @param string $path absolute path of the source image
     * @param int $width width of the placeholder
     * @return string data URI, or an empty string if the image could not be read
     */
    private static function generate(string $path, int $width) : string {

        if(!extension_loaded('gd')) return '';

        $info = @getimagesize($path);

        if(!$info || !isset(self::readers[$info[2]])) return '';

        [$sourceWidth, $sourceHeight] = $info;

        if($sourceWidth < 1 || $sourceHeight < 1) return '';

        $reader = self::readers[$info[2]];
        $source = @$reader($path);

        if(!$source) return '';

        // an image already smaller than the placeholder is its own placeholder
        $width  = min($width, $sourceWidth);
        $height = max(1, (int) round($sourceHeight * ($width / $sourceWidth)));

        $thumb = imagecreatetruecolor($width, $height);

        /* a source with alpha has to keep it, or a transparent PNG comes back with a
           black ground behind it — which is far more noticeable blurred than sharp */
        $alpha = in_array($info[2], [IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP], true);

        if($alpha){
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
            imagefill($thumb, 0, 0, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
        }

        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $height, $sourceWidth, $sourceHeight);

        ob_start();
        if($alpha){
            imagepng($thumb, null, 9);
            $mime = 'image/png';
        }else{
            imagejpeg($thumb, null, self::$quality);
            $mime = 'image/jpeg';
        }
        $binary = (string) ob_get_clean();

        imagedestroy($thumb);
        imagedestroy($source);

        if($binary === '') return '';

        return 'data:'.$mime.';base64,'.base64_encode($binary);

    }

    /**
     * Cache key for an image at a given width.
     *
     * The modification time is part of the key, so an edited image gets a new
     * placeholder on its next read rather than serving the old one forever.
     *
     * @param string $path absolute path of the source image
     * @param int $width width of the placeholder
     * @return string
     */
    private static function key(string $path, int $width) : string {
        return sha1($path.'|'.filemtime($path).'|'.$width.'|'.self::$quality);
    }

    /**
     * Absolute path of the cache entry for a key.
     *
     * @param string $key
     * @return string
     */
    private static function cachePath(string $key) : string {
        return self::directory().DIRECTORY_SEPARATOR.$key.'.txt';
    }

    /**
     * Absolute path of the cache directory.
     *
     * @return string
     */
    public static function directory() : string {
        $root = defined('docroot') ? docroot : dirname(__DIR__, 3);
        return rtrim($root, '\\/').DIRECTORY_SEPARATOR.trim(self::$cacheDir, '\\/');
    }

    /**
     * Write a placeholder to the cache.
     *
     * A cache that cannot be written is not an error worth surfacing — the
     * placeholder was generated either way and the page renders. It just costs
     * the work again next request.
     *
     * @param string $file absolute path of the cache entry
     * @param string $uri data URI to store
     * @return bool whether the entry was written
     */
    private static function store(string $file, string $uri) : bool {

        $directory = dirname($file);

        if(!is_dir($directory) && !@mkdir($directory, 0777, true) && !is_dir($directory)){
            return false;
        }

        return @file_put_contents($file, $uri) !== false;

    }

    /**
     * Empty the placeholder cache.
     *
     * @return int number of entries removed
     */
    public static function clear() : int {

        $removed = 0;

        foreach(glob(self::directory().DIRECTORY_SEPARATOR.'*.txt') ?: [] as $file){
            if(@unlink($file)) $removed++;
        }

        self::$memo = [];

        return $removed;

    }

}
