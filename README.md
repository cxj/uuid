# uuid
Provides a native PHP implementation of UUID creation.

This class supports version 4 (random) and version 5 (SHA-1) UUID
generation algorithms.  It generates the DCE 1.1 variant UUID, the most
common outside of Microsoft environments.

The UUIDs generated are RFC 4122 compliant.


## Introduction

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


### Design Goals

This class was designed to cover only the most common use cases and to be 
small and lightweight.  Hence, there are some features it does not provide.

In particular:

* It does not provide a version 1 (MAC address) implementation, because there is no reliable and lightweight method to obtain the MAC address from PHP.  There are also criticisms of version 1 which make it less desirable.

* Version 2 (DEC Security) is also not presently implemented.  The need for this version appears small.

* It does not provide a version 3 (MD5) implementation.  MD5 has been shown to have weaknesses, and version 5 (SHA-1) is recommended for usage instead.

* It is a UUID generator, so very little UUID parsing and validation is part of the code at present.



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
