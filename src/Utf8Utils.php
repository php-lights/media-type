<?php

namespace Neoncitylights\MediaType;

use IntlChar;
use Wikimedia\Assert\Assert;

/**
 * @internal
 * @license MIT
 */
final readonly class Utf8Utils {
	public static function onlyContains( string $input, callable $predicateFn ): bool {
		if ( $input === '' ) {
			return true;
		}

		for ( $i = 0; $i < \strlen( $input ); $i++ ) {
			if ( !$predicateFn( $input[$i] ) ) {
				return false;
			}
		}

		return true;
	}

	public static function trimHttpWhitespace( string $input ): string {
		if ( $input === '' ) {
			return '';
		}

		$startIndex = 0;
		$inputLength = \strlen( $input );
		while ( $startIndex < $inputLength && self::isHttpWhitespace( $input[$startIndex] ) ) {
			$startIndex++;
		}

		$endIndex = $inputLength;
		while ( $endIndex > $startIndex && self::isHttpWhitespace( $input[$endIndex - 1] ) ) {
			$endIndex--;
		}

		$substringLength = $endIndex - $startIndex;
		return \substr( $input, $startIndex, $substringLength );
	}

	/**
	 * @see https://fetch.spec.whatwg.org/#collect-an-http-quoted-string
	 * @throws Wikimedia\Assert\InvariantException
	 */
	public static function collectHttpQuotedString(
		string $input,
		int &$position,
		?bool $extractValue = false
	): string {
		if ( $input === '' ) {
			return '';
		}

		$positionStart = $position;
		$value = '';

		$expectedQuote = fn ( string $input, int $position, string $value ) =>
			"Codepoint in \"{$input}\" at position {$position} is {$value}, expected U+0022 (\")";
		Assert::invariant(
			fn () => $input[$position] === '"',
			$expectedQuote( $input, $position, $input[$position] ) );

		$position++;

		while ( true ) {
			$value .= self::collectCodepoints(
				$input, $position,
				fn ( string $c ) => $c !== '"' && $c !== '\\' );

			if ( $position >= \strlen( $input ) ) {
				break;
			}

			$quoteOrBackslash = $input[$position];
			$position++;

			if ( $quoteOrBackslash === '\\' ) {
				if ( $position >= \strlen( $input ) ) {
					$value .= '\\';
					break;
				}
				$value .= $input[$position];
				$position++;
			} else {
				Assert::invariant(
					fn () => $quoteOrBackslash === '"',
					$expectedQuote( $input, $position, $quoteOrBackslash ) );
				break;
			}
		}

		if ( $extractValue ) {
			return $value;
		}

		$substringLength = $position - $positionStart;
		return \substr( $input, $positionStart, $substringLength );
	}

	/**
	 * @see https://infra.spec.whatwg.org/#collect-a-sequence-of-code-points
	 */
	public static function collectCodepoints( string $input, int &$position, callable $predicateFn ): string {
		$length = \strlen( $input );
		if ( $input === '' || $position >= $length ) {
			return '';
		}

		$result = '';
		while ( $position < $length && $predicateFn( $input[$position] ) ) {
			$result .= $input[$position];
			$position++;
		}

		return $result;
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#http-token-code-point
	 */
	public static function isHttpTokenCodepoint( string $codepoint ): bool {
		$value = IntlChar::ord( $codepoint );

		return $value === 0x21
			|| self::isCodepointBetween( $value, 0x23, 0x27 )
			|| $value === 0x2A || $value === 0x2B
			|| $value === 0x2D || $value === 0x2E
			|| self::isCodepointBetween( $value, 0x5E, 0x60 )
			|| $value === 0x7C || $value === 0x7E
			|| \ctype_alnum( IntlChar::chr( $codepoint ) );
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#http-quoted-string-token-code-point
	 */
	public static function isHttpQuotedStringTokenCodepoint( string $codepoint ): bool {
		$value = IntlChar::ord( $codepoint );

		return self::isCodepointBetween( $value, 0x20, 0x21 )
			|| self::isCodepointBetween( $value, 0x23, 0x5B )
			|| self::isCodepointBetween( $value, 0x5D, 0x7E )
			|| self::isCodepointBetween( $value, 0x80, 0xFF );
	}

	/**
	 * @see https://fetch.spec.whatwg.org/#http-whitespace
	 */
	public static function isHttpWhitespace( string $codepoint ): bool {
		return $codepoint === '\n' || $codepoint === '\r'
			|| $codepoint === '\t' || $codepoint === ' ';
	}

	private static function isCodepointBetween( int $codepoint, int $lowerBound, int $upperBound ): bool {
		return $codepoint >= $lowerBound && $codepoint <= $upperBound;
	}
}
