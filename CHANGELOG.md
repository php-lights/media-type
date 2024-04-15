# Changelog

## 3.1.0 (YYYY-MM-DD)

### Features

- `MediaTypeParser::parseOrNull()`, `MediaTypeParse::parse()` now also accepts passing `null` values as an argument, the new argument type is `string|null`.


### Bug fixes

- Fixes minor bug in `MediaType::isFont()` method; it will now correctly return `true` for media types that have an essence of `application/vnd.ms-opentype`.

### Deprecated

- `MediaTypeParser::parse()` is deprecated and renamed to `MediaTypeParser::parseOrThrow()`, to be more explicit that it can throw exceptions. Call `MediaTypeParser::parseOrThrow()` instead.

## 3.0.0 (2024-04-03)

### Breaking changes

- The library now requires PHP 8.2+ (originally 8.1+). This breaking change comes from bumping the developer dependency PHPUnit from v9 to v11.

### Documentation

- The `README.md` file now includes usage examples for serialization and matching. ([#49](https://github.com/neoncitylights/php-media-type/pull/49))

### Internal changes

- Simplify number of jobs in main CI workflow ([#48](https://github.com/neoncitylights/php-media-type/pull/48))
- Refactors `MediaType` class internally by factoring out subtype matching ([#45](https://github.com/neoncitylights/php-media-type/pull/45))
- Bumps `mediawiki/mediawiki-codesniffer` developer dependency from `v42.0.0` to `v43.0.0`. ([#38](https://github.com/neoncitylights/php-media-type/pull/38))
- Bumps `php-parallel-lint/php-parallel-lint` developer dependency from `1.3.2` to `v1.4.0`. ([#47](https://github.com/neoncitylights/php-media-type/pull/47))
- Bumps `phpunit/phpunit` developer dependency from `v9.6.15` to `v11.0.8`. ([#46](https://github.com/neoncitylights/php-media-type/pull/46))

## 2.1.0 (2024-03-27)

### Features

- `MediaType` now has a new method, `minimize( $isSupported )`. This method allows returning a consistent essence as a string, depending on what category the media type is and whether the user agent supports the media type. For example, if the media type is a JavaScript type, then it will consistently return `"text/javascript"`.

### Documentation

- Fixes minor phpDoc annotation issues within `MediaType`. Specifically:
  - Removes redundant `@return` annotations that are already specified from return typehints
  - Removes redundant `@param` annotation from `getParameterValue()`
  - Adds missing `@see` annotation to `isAudioOrVideo()` method in reference to a WHATWG Standard link

## 2.0.0 (2023-12-11)

### Features

 - `MediaTypeParser` is a new parser that is more compliant to WHATWG Mime Sniffing Standard. The following differences include:
   - validates for Unicode ranges of HTTP codepoints and HTTP quoted-string codepoints
   - normalizes the type and subtype to ASCII lowercase
   - is more forgiving with surrounding HTTP whitespace codepoints
   - accounts for HTTP-quoted strings in parameter values, and normalizes such values
   - will error out when the type or subtype is empty
 - `MediaType` now implements the native `Stringable` interface (introduced by PHP 8.1).
 - `MediaType` now includes built-in predicate methods for checking what group the media type belongs to:
   - `isImage()`
   - `isAudioOrVideo()`
   - `isFont()`
   - `isZipBased()`
   - `isArchive()`
   - `isXml()`
   - `isHtml()`
   - `isScriptable()`
   - `isJavaScript()`
   - `isJson()`

### Bug fixes

 - `MediaType::__toString()` now correctly serializes HTTP parameter values that contain HTTP-quoted strings.

### Breaking changes

 - The package now requires PHP 8.1 or higher, and the native `intl` extension.
 - The following classes are now marked as `final`:
   - `MediaType`
   - `MediaTypeParser`
   - `MediaTypeParseException`
 - The `MediaType` class now has public and readonly properties. Access these instead:
   - `$mediaType->type` replaces `MediaType->getType()` (removed)
   - `$mediaType->subType` replaces `MediaType->getSubType()` (removed)
   - `$mediaType->parameters` replaces `MediaType->getParameters()` (removed)
 - `MediaType::newFromString()` is removed. Instead, create a new `MediaTypeParser` instance and call `parseOrNull()`.

### Notes
 - The `Utf8Utils` class and `Token` enum are **internal**, and therefore not part of the public API. They may be changed or removed at any time.

## 1.0.0 (2020-10-28)

### Notes

 - First release
