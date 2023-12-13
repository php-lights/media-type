<?php

namespace Neoncitylights\MediaType\Tests;

use Neoncitylights\MediaType\MediaType;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Neoncitylights\MediaType\MediaType
 */
class MediaTypeTest extends TestCase {
	/**
	 * @covers ::__construct
	 */
	public function testConstructor(): void {
		$this->assertInstanceOf(
			MediaType::class,
			new MediaType( 'text', 'plain', [] )
		);
	}

	/**
	 * @covers ::getEssence
	 * @dataProvider provideEssences
	 */
	public function testGetEssence( string $type, string $subType, string $expectedEssence ): void {
		$this->assertEquals(
			$expectedEssence,
			( new MediaType( $type, $subType, [] ) )->getEssence()
		);
	}

	/**
	 * @covers ::getParameterValue
	 * @dataProvider provideParameterValues
	 */
	public function testGetParameterValue(
		string $type,
		string $subType,
		array $givenParameters,
		string $parameterName,
		string|null $expectedParameterValue
	): void {
		$this->assertEquals(
			$expectedParameterValue,
			( new MediaType( $type, $subType, $givenParameters ) )->getParameterValue( $parameterName )
		);
	}

	/**
	 * @covers ::__toString
	 * @dataProvider provideStrings
	 */
	public function testToString(
		string $type,
		string $subType,
		array $givenParameters,
		string $expectedString
	): void {
		$this->assertEquals(
			$expectedString,
			(string)new MediaType( $type, $subType, $givenParameters )
		);
	}

	public function provideEssences() {
		return [
			[
				'text',
				'plain',
				'text/plain',
			],
			[
				'application',
				'xhtml+xml',
				'application/xhtml+xml',
			],
			[
				'application',
				'vnd.openxmlformats-officedocument.presentationml.presentation',
				'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			],
		];
	}

	public function provideParameters() {
		return [
			[
				'text',
				'plain',
				[ 'charset' => 'UTF-8' ],
				[ 'charset' => 'UTF-8' ],
			],
			[
				'text',
				'plain',
				[],
				[],
			],
		];
	}

	public function provideParameterValues() {
		return [
			[
				'text',
				'plain',
				[ 'charset' => 'UTF-8' ],
				'charset',
				'UTF-8'
			],
			[
				'text',
				'plain',
				[],
				'charset',
				null,
			]
		];
	}

	public function provideStrings() {
		return [
			[
				'text',
				'input',
				[],
				'text/input',
			],
			[
				'text',
				'plain',
				[ 'charset' => 'UTF-8' ],
				'text/plain;charset=UTF-8',
			],
			[
				'text',
				'plain',
				[ 'param' => '' ],
				"text/plain;param=\"\"",
			],
			[
				'application',
				'vnd.openxmlformats-officedocument.presentationml.presentation',
				[],
				'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			]
		];
	}
}
