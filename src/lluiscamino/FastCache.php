<?php


namespace lluiscamino;


class FastCache {

    /**
     * @var bool Disable caching.
     */
    public static $disabled = false;

    /**
     * @var string Cache files directory path
     */
    public static $path = 'cache';

    /**
     * @var bool Include comment if the page is loaded from cache.
     */
    public static $announce = true;
    private $dir;
    private $cache;
    private $time;

    /**
     * FastCache constructor.
     * @param int $time Lifetime of the cache file (in seconds).
     * @param string|null $file File (file.php) that identifies the page being cached. Leave blank to automatically
     * select the file from which the object is being created.
     * @param string $dir Subdirectory in which the cache file will be stored.
     */
    public function __construct(int $time, string $file = null, string $dir = '') {
        $this->dir = $dir;
        if ($file === null) {
            $temp = explode('/', $_SERVER['SCRIPT_NAME']);
            $file = end($temp);
        }
        $this->cache = self::$path . '/' . $this->dir . '/' . substr_replace($file, '', -4) . '.html';
        $this->time = $time;
    }

    /**
     * Call at the beginning of the file.
     */
    public function start(): void {
        if (self::$disabled) return;
        if (file_exists($this->cache) && (time() - $this->time) < ($cacheTime = filemtime($this->cache))) {
            if (self::$announce) echo '<!-- Serving cached file from ' . date('H:i:s', $cacheTime) . ' -->';
            readfile($this->cache);
            exit;
        }
        ob_start();
    }

    /**
     * Call at the end of the file.
     */
    public function end(): void {
        if (self::$disabled) return;
        if (!is_dir(self::$path . '/' . $this->dir)) {
            mkdir(self::$path . '/' . $this->dir, 0777, true);
        }
        $cacheFile = fopen($this->cache, 'w');
        fwrite($cacheFile, ob_get_contents());
        fclose($cacheFile);
        ob_end_flush();
    }

    /**
     * Delete cached file.
     */
    public function delete(): void {
        unlink($this->cache);
    }
}