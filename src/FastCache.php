<?php


namespace lluiscamino;


class FastCache {

    /**
     * @var string Cache files directory path
     */
    public static $path = 'cache';

    /**
     * @var bool Include comment if the page is loaded from cache.
     */
    public static $announce = true;
    private $file;
    private $cache;
    private $time;

    /**
     * FastCache constructor.
     * @param int $time Lifetime of the cache file (in seconds).
     * @param string|null $file File (file.php) that identifies the page being cached. Leave blank to automatically
     * select the file from which the object is being created.
     */
    public function __construct(int $time, string $file = null) {
        if ($file === null) {
            $temp = explode('/', $_SERVER['SCRIPT_NAME']);
            $this->file = end($temp);
        } else {
            $this->file = $file;
        }
        $this->cache = self::$path . '/' . substr_replace($this->file, '', -4) . '.html';
        $this->time = $time;
    }

    /**
     * Call at the beginning of the file.
     */
    public function start(): void {
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
        if (!is_dir(self::$path)) {
            mkdir(self::$path, 0777, true);
        }
        $cacheFile = fopen($this->cache, 'w');
        fwrite($cacheFile, ob_get_contents());
        fclose($cacheFile);
        ob_end_flush();
    }
}