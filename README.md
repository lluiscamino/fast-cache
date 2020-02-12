# fast-cache
Simple caching system for PHP applications.

## Installing
Use the following command to install via Composer:
```
composer require lluiscamino/fast-cache
```

## Usage
```php
$cache = new FastCache(21600); // Cache lifetime in seconds
$cache->start();
echo "Hola!"; // Display content
$cache->end();
```

Once a user visits your website for the first time, a cached version of the page will be created and served for the following requests in the specified time.

If for some reason you don't want the current content to be saved, you can finish with `$cache->end(false);` and the content will not be cached.

Apart from time, you can also specify two more parameters in the constructor:
```php
__construct(int $time, string $file = null, string $dir = '')
```
* `string $file`: Name of the (file.php) that identifies the page being cached. Use this option to create different cached versions of the same page. Leave blank to automatically select the file from which the object is being created.
* `string $dir`: Subdirectory where the cache file of the page will be saved.

### Configuration
```php
FastCache::$path = 'custom-dir'; // Cache files directory
FastCache::$announce = false; // Disable "Serving cached file fromServing cached file from..." comment
```
