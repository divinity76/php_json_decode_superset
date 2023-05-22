# php_json_decode_superset

superset of PHP's json_decode, allowing decoding of javascript objects (useful for web scraping)

# Installation

install with Composer (recommended):

```
composer require divinity76/json_decode_superset;
```

alternatively, because it is a standalone php file, you may download the file `json_decode_superset.php` and include it in your project.

# Usage

```php
<?php
declare(strict_types=1);
require_once('vendor/autoload.php');
use function Divinity76\json_decode_superset\json_decode_superset;
$json_superset = '{test: "valid javascript object, but invalid json"}';
$php_array = json_decode_superset($json_superset, true, 512, JSON_THROW_ON_ERROR);
var_dump($php_array); // array(1) { ["test"]=> string(37) "valid javascript object, but invalid json" }

?>
```

# Credits

Much of the code is borrowed from the Services_JSON library available at https://pear.php.net/package/Services_JSON, authored by Michal Migurski (mike-json@teczno.com), Matt Knapp (mdknapp[at]gmail[dot]com), and Brett Stimmerman (brettstimmerman[at]gmail[dot]com)

```

```
