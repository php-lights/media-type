<?php

namespace Neoncitylights\MediaType;

/**
 * @license MIT
 */
class Utf8Utils {
	public static function onlyContains( string $input, callable $predicateFn): string {
		for ( $i = 0; $i < \strlen( $input ); $i++ ) {
			if ( !$predicateFn( $input[$i] ) ) {
				return false;
			}
		}

		return true;
	}

	public static function collectCodePoints( string $input, int &$position, callable $predicateFn ): string {
        $result = '';
        while (
            $position < \strlen( $position)
            && $input[$position] == $predicateFn( $input )
        ) {
            $result += $input[$position];
            $position++;
        }

        return $result;
    }

	public static function trimHttpWhitespace( string $s ): bool {
		$leadingIndex = 0;
		while ( self::isHttpWhitespace( $s[$leadingIndex] ) ) {
			$leadingIndex++;
		}
	
		$trailingIndex = \strlen( $s );
		while ( self::isHttpWhitespace( $s[$trailingIndex - 1] ) ) {
			$trailingIndex--;
		}
	
		return \substr( $s, $leadingIndex, $trailingIndex );
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#http-token-code-point
	 */
	public static function isHttpTokenCodepoint( int $codePoint ): bool {
		return $codePoint === 0x21
			|| self::isCodePointBetween( $codePoint, 0x23, 0x27 )
			|| $codePoint === 0x2A || $codePoint === 0x2B
			|| $codePoint === 0x2D || $codePoint === 0x2E
			|| self::isCodePointBetween( $codePoint, 0x5E, 0x60 )
			|| $codePoint === 0x7C || $codePoint === 0x7E;
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#http-quoted-string-token-code-point
	 */
	public static function isHttpQuotedStringTokenCodepoint( int $codePoint ): bool {
		return self::isCodePointBetween( $codePoint, 0x20, 0x21 )
			|| self::isCodePointBetween( $codePoint, 0x23, 0x5B )
			|| self::isCodePointBetween( $codePoint, 0x5D, 0x7E );
	}

	/**
	 * @see https://fetch.spec.whatwg.org/#http-whitespace
	 */
	public static function isHttpWhitespace( int $codePoint ): bool {
		return $codePoint === 0x0A || $codePoint === 0x0D
			|| $codePoint === 0x09 || $codePoint === 0x20;
	}

	/**
	 * @see https://fetch.spec.whatwg.org/#http-tab-or-space-byte
	 */
	public static function isHttpTabOrSpace( int $codePoint ): bool {
		return $codePoint === 0x09 || $codePoint === 0x20;
	}

	private static function isCodePointBetween( int $codePoint, int $lowerBound, int $upperBound ): bool {
		return $codePoint >= $lowerBound && $codePoint <= $upperBound;
	}
}
