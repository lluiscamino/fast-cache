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

You can also finish with `$cache->end(false);` if you don't want the current content to be saved.

### Configuration
```php
FastCache::$path = 'custom-dir'; // Cache files directory
FastCache::$announce = false; // Disable "Serving cached file fromServing cached file from..." comment
```
