# MediaType
MediaType is a PHP library for dealing with IANA media types as entities.

## Install
```bash
composer install neoncitylights/media-type
```

## Usage
```php
<?php

use Neoncitylights\MediaType\MediaType;

$mediaType = MediaType::newFromString( 'text/plain;charset=UTF-8' );

print( $mediaType->getType() );
// 'text'

print( $mediaType->getSubType() );
// 'plain'

print( $mediaType->getEssence() );
// 'text/plain'

print( $mediaType->getParameterValue( 'charset' ) );
// 'UTF-8'
```
