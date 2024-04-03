# MediaType
![Packagist Version](https://img.shields.io/packagist/v/neoncitylights/media-type?style=flat-square)
![GitHub](https://img.shields.io/github/license/neoncitylights/php-media-type?style=flat-square)
![Build Status](https://img.shields.io/github/actions/workflow/status/neoncitylights/php-media-type/.github%2Fworkflows%2Fphp.yml?style=flat-square)
[![Code coverage](https://img.shields.io/codecov/c/github/neoncitylights/php-media-type?style=flat-square&token=0qtwQLpV57)](https://codecov.io/gh/neoncitylights/php-media-type)

**MediaType** is a PHP library for dealing with IANA media types as entities.

This library is compliant to the parsing section of the [WHATWG Mime Sniffing Standard](https://mimesniff.spec.whatwg.org/).

## Install

System requirements:

- Minimum PHP version: 8.2
- [`intl`](https://www.php.net/intl) PHP extension ([installation instructions](https://www.php.net/manual/en/intl.installation.php))

```bash
composer require neoncitylights/media-type
```

## Usage
```php
<?php

use Neoncitylights\MediaType\MediaType;
use Neoncitylights\MediaType\MediaTypeParser;

$parser = new MediaTypeParser();
$mediaType = $parser->parseOrNull( 'text/plain;charset=UTF-8' );

print( $mediaType->type ); // 'text'
print( $mediaType->subType ); // 'plain'
print( $mediaType->getEssence() ); // 'text/plain'
print( $mediaType->getParameterValue( 'charset' ) ); // 'UTF-8'
```

## License
MediaType is licensed under the [MIT license](/LICENSE).
