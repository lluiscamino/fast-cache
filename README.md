# fast-cache
Simple caching system for PHP applications.

## Installing

## Usage
```php
$cache = new FastCache(21600); // Cache lifetime in seconds
$cache->start();
echo "Hola!"; // Display content
$cache->end();
```

### Configuration
```php
FastCache::$path = 'custom-dir'; // Cache files directory
FastCache::$announce = false; // Disable "Serving cached file fromServing cached file from..." comment
```