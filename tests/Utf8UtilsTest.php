<?php

namespace Neoncitylights\MediaType\Tests;

use Neoncitylights\MediaType\Utf8Utils;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Neoncitylights\MediaType\Utf8Utils
 */
class Utf8UtilsTest extends TestCase {
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
			Utf8Utils::collectCodepoints( $originalString, $position, $predicateFn ),
			$newString
		);
		$this->assertEquals( $position, $newPosition );
	}

	/**
	 * @covers ::isHttpWhitespace
	 * @dataProvider provideIsHttpWhitespace
	 */
	public function testIsHttpWhitespace(
		string $input,
		bool $expected
	): void {
		$this->assertEquals( $expected, Utf8Utils::isHttpWhitespace( $input ) );
	}

	public function provideTrimHttpWhitespace(): array {
		return [
			[ '', '' ],
			[ ' test ', 'test' ],
		];
	}

	public function provideCollectCodepoints(): array {
		return [
			[ '', 0, '', 0, fn() => true ],
			[ '1234test', 0, '1234', 4, fn(string $s) => \ctype_digit($s)],
			[ 'test1234', 0, 'test', 4, fn(string $s) => \ctype_alpha($s)],
			[ 'foo/bar', 0, 'foo', 3, fn(string $s) => $s !== '/' ],
			[ 'foo/bar;', 0, 'foo/bar', 7, fn(string $s) => $s !== ';' ],
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
