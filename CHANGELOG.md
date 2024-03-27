# Changelog

## Unreleased (YYYY-MM-DD)

### Features

- `MediaType` now has a new method, `minimize( $isSupported )`. This method allows returning a consistent essence as a string, depending on what category the media type is and whether the user agent supports the media type. For example, if the media type is a JavaScript type, then it will consistently return `"text/javascript"`.

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
