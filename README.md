# MediaType
[![Packagist version][packagist-badge]][packagist-url]
[![License][license-badge]][license-url]
[![Docs][docs-badge]][docs-url]
[![CI][ci-badge]][ci-url]
[![Code coverage][codecov-badge]][codecov-url]

[packagist-badge]: https://img.shields.io/packagist/v/neoncitylights/media-type?style=flat-square
[packagist-url]: https://packagist.org/packages/neoncitylights/media-type
[license-badge]: https://img.shields.io/badge/License-MIT-blue?style=flat-square
[license-url]: #license
[docs-badge]: https://img.shields.io/github/deployments/php-lights/media-type/github-pages?label=docs&style=flat-square
[docs-url]: https://php-lights.github.io/media-type/
[ci-badge]: https://img.shields.io/github/actions/workflow/status/php-lights/media-type/.github%2Fworkflows%2Fphp.yml?style=flat-square
[ci-url]: https://github.com/php-lights/media-type/actions/workflows/php.yml
[codecov-badge]: https://img.shields.io/codecov/c/github/php-lights/media-type?style=flat-square
[codecov-url]: https://codecov.io/gh/php-lights/media-type

**MediaType** is a PHP library for parsing and serializing MIME types, also known as IANA media types.

This library is compliant to the [WHATWG Mime Sniffing Standard](https://mimesniff.spec.whatwg.org/).

## Install
System requirements:

- Minimum PHP version: 8.2
- [`intl`](https://www.php.net/intl) PHP extension ([installation instructions](https://www.php.net/manual/en/intl.installation.php))

```bash
composer require neoncitylights/media-type
```

## Usage

### Parsing
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

### Serializing
```php
<?php

use Neoncitylights\MediaType\MediaType;

$mediaType1 = new MediaType( 'text', 'plain', [ 'charset' => 'UT-8' ] );
$mediaType1->toString(); // 'text/plain;charset=UTF-8'

$mediaType2 = new MediaType( 'application', 'json', [] );
$mediaType2->toString(); // 'application/json'
```

### Matching
```php
<?php

use Neoncitylights\MediaType\MediaType;
use Neoncitylights\MediaType\MediaTypeParser;

$parser = new MediaTypeParser();

$parser->parseOrNull( 'audio/midi' )->isAudioOrVideo(); // true
$parser->parseOrNull( 'audio/ogg' )->isAudioOrVideo(); // true
$parser->parseOrNull( 'application/ogg' )->isAudioOrVideo(); // true
```

## License
This software is licensed under the MIT license ([`LICENSE-MIT`](./LICENSE) or <https://opensource.org/license/mit/>).

### Contribution
Unless you explicitly state otherwise, any contribution intentionally submitted for inclusion in the work by you, as defined in the MIT license, shall be licensed as above, without any additional terms or conditions.
