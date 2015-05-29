# uuid
Provides a native PHP implementation of UUID creation.

This class supports version 4 (random) and version 5 (SHA-1) UUID
generation algorithms.  It generates the DCE 1.1 variant UUID, the most
common outside of Microsoft environments.

The UUIDs generated are RFC 4122 compliant.


## Foreword

### Installation

This class only requires PHP 4 or later, but we recommend using the latest
available version of PHP as a matter of principle.  It has no dependencies.

It is installable and autoloadable via Composer as [cxj/uuid]
(https://packagist.org/packages/cxj/uuid).

Alternatively, [download a release]
(https://github.com/cxj/uuid/releases) or clone this repository, then require
or include its _autoload.php_ file.


### Quality

This class attempts to comply with [PSR-1][], [PSR-2][], and [PSR-4][]. If
you notice compliance oversights, please send a patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md


## Usage

The UUID generation methods are static, so simply call them as shown below.

```php
<?php

$namespace_uuid = '1546058f-5a25-4334-85ae-e68f2a44bbaf';

// Some meaningful string, e.g. fully-qualified domain name, URL, distinguished
// name, or any other textual name.
$name = 'http://example.com/';

$v4uuid = UUID::v4();
$v5uuid = UUID::v5($v4uuid, $name);
$v5uuid2 = UUID::v5($namespace_uuid, $name);


echo "v4: $v4uuid" .PHP_EOL;
echo "v5: $v5uuid" .PHP_EOL;
echo "v5: $v5uuid2" .PHP_EOL;

?>
```
