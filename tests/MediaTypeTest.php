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
	 * @covers ::getType
	 * @dataProvider provideTypes
	 */
	public function testGetType( string $subType, string $type ): void {
		$this->assertEquals(
			$type,
			( new MediaType( $type, $subType, [] ) )->getType()
		);
	}

	/**
	 * @covers ::getSubType
	 * @dataProvider provideSubTypes
	 */
	public function testGetSubType( string $subType, string $type ): void {
		$this->assertEquals(
			$subType,
			( new MediaType( $type, $subType, [] ) )->getSubType()
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
	 * @covers ::getParameters
	 * @dataProvider provideParameters
	 */
	public function testGetParameters(
		string $type,
		string $subType,
		array $givenParameters,
		array $expectedParameters
	): void {
		$this->assertEquals(
			$expectedParameters,
			( new MediaType( $type, $subType, $givenParameters ) )->getParameters()
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

	public function provideInvalidMediaTypes() {
		return [
			[ '' ],
		];
	}

	public function provideTypes() {
		return [
			[
				'text',
				'text/plain',
			],
			[
				'application',
				'application/xhtml+xml',
			],
			[
				'application',
				'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			],
		];
	}

	public function provideSubTypes() {
		return [
			[
				'plain',
				'text/plain',
			],
			[
				'xhtml+xml',
				'application/xhtml+xml',
			],
			[
				'vnd.openxmlformats-officedocument.presentationml.presentation',
				'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			],
		];
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
				'application',
				'vnd.openxmlformats-officedocument.presentationml.presentation',
				[],
				'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			]
		];
	}
}
