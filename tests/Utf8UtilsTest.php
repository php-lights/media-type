<?php

namespace Neoncitylights\MediaType\Tests;

use IntlChar;
use Neoncitylights\MediaType\Utf8Utils;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Neoncitylights\MediaType\Utf8Utils
 */
class Utf8UtilsTest extends TestCase {
	/**
	 * @covers ::onlyContains
	 * @dataProvider provideOnlyContains
	 */
	public function testOnlyContains(
		string $input,
		callable $predicateFn,
		bool $expected
	): void {
		$this->assertEquals(
			$expected,
			Utf8Utils::onlyContains( $input, $predicateFn )
		);
	}

	/**
	 * @covers ::trimHttpWhitespace
	 * @dataProvider provideTrimHttpWhitespace
	 */
	public function testTrimHttpWhitespace(
		string $inputValue,
		string $expectedOutputValue
	): void {
		$this->assertEquals(
			$expectedOutputValue,
			Utf8Utils::trimHttpWhitespace( $inputValue )
		);
	}

	/**
	 * @covers ::collectHttpQuotedString
	 * @dataProvider provideCollectHttpQuotedString
	 */
	public function testCollectHttpQuotedString(
		string $input,
		int $startingPosition,
		bool $shouldExtractValue,
		string $expectedOutput,
		int $expectedFinalPosition,
	): void {
		$position = $startingPosition;

		$this->assertEquals(
			$expectedOutput,
			Utf8Utils::collectHttpQuotedString( $input, $position, $shouldExtractValue )
		);
		$this->assertEquals(
			$expectedFinalPosition,
			$position,
		);
	}

	/**
	 * @covers ::collectCodepoints
	 * @dataProvider provideCollectCodepoints
	 */
	public function testCollectCodepoints(
		string $originalString,
		int $originalPosition,
		string $newString,
		int $newPosition,
		\Closure $predicateFn
	): void {
		$position = $originalPosition;

		$this->assertEquals(
			$newString,
			Utf8Utils::collectCodepoints( $originalString, $position, $predicateFn )
		);
		$this->assertEquals( $position, $newPosition );
	}

	/**
	 * @covers ::isHttpTokenCodepoint
	 * @dataProvider provideIsHttpTokenCodepoint
	 */
	public function testIsHttpTokenCodepoint(
		string $codepoint,
		bool $expected
	): void {
		$this->assertEquals(
			$expected,
			Utf8Utils::isHttpTokenCodepoint( $codepoint )
		);
	}

	/**
	 * @covers ::isHttpQuotedStringTokenCodepoint
	 * @dataProvider provideIsHttpQuotedStringTokenCodepoint
	 */
	public function testIsHttpQuotedStringTokenCodepoint(
		string $codepoint,
		bool $expected
	): void {
		$this->assertEquals(
			$expected,
			Utf8Utils::isHttpQuotedStringTokenCodepoint( $codepoint )
		);
	}

	/**
	 * @covers ::isHttpWhitespace
	 * @dataProvider provideIsHttpWhitespace
	 */
	public function testIsHttpWhitespace(
		string $input,
		bool $expected
	): void {
		$this->assertEquals(
			$expected,
			Utf8Utils::isHttpWhitespace( $input )
		);
	}

	public function provideOnlyContains(): array {
		return [
			[ '', fn ( string $c ) => \ctype_alpha( $c ), true ],
			[ 'test', fn ( string $c ) => \ctype_alpha( $c ), true ],
			[ '1234', fn ( string $c ) => \ctype_digit( $c ), true ],
			[ '1234test', fn ( string $c ) => \ctype_digit( $c ), false ],
			[ 'test1234', fn ( string $c ) => \ctype_alpha( $c ), false ],
			[ 'test1234', fn ( string $c ) => \ctype_alnum( $c ), true ],
		];
	}

	public function provideTrimHttpWhitespace(): array {
		return [
			[ '', '' ],
			[ ' test ', 'test' ],
			[ '      ', '' ],
		];
	}

	public function provideCollectHttpQuotedString(): array {
		return [
			[
				"\"\\",
				0,
				false,
				"\"\\",
				2,
			],
			[
				"\"Hello\" World",
				0,
				false,
				"\"Hello\"",
				7,
			],
			[
				"\"Hello \\\\ World\\\"\"",
				0,
				false,
				"\"Hello \\\\ World\\\"\"",
				18,
			]
		];
	}

	public function provideCollectCodepoints(): array {
		return [
			[ '', 0, '', 0, fn () => true ],
			[ '1234test', 0, '1234', 4, fn ( string $s ) => \ctype_digit( $s ) ],
			[ 'test1234', 0, 'test', 4, fn ( string $s ) => \ctype_alpha( $s ) ],
			[ 'foo/bar', 0, 'foo', 3, fn ( string $s ) => $s !== '/' ],
			[ 'foo/bar;', 0, 'foo/bar', 7, fn ( string $s ) => $s !== ';' ],
		];
	}

	public function provideIsHttpTokenCodepoint(): array {
		return [
			[ IntlChar::chr( 0x24 ), true ],
			[ IntlChar::chr( 0x28 ), false ],
		];
	}

	public function provideIsHttpQuotedStringTokenCodepoint(): array {
		return [
			[ IntlChar::chr( 0x20 ), true ],
			[ IntlChar::chr( 0x21 ), true ],
			[ IntlChar::chr( 0x22 ), false ],
			[ IntlChar::chr( 0x5C ), false ],
			[ IntlChar::chr( 0x7F ), false ],
		];
	}

	public function provideIsHttpWhitespace(): array {
		return [
			[ '\n', true ],
			[ '\r', true ],
			[ '\t', true ],
			[ ' ', true ],
			[ 't', false ],
		];
	}
}
