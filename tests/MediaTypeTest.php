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
	 * @covers ::newFromString
	 * @dataProvider provideValidMediaTypes
	 */
	public function testIsValidMediaType( $validMediaType ): void {
		$this->assertInstanceOf( MediaType::class, MediaType::newFromString( $validMediaType ) );
	}

	/**
	 * @covers ::newFromString
	 * @dataProvider provideInvalidMediaTypes
	 */
	public function testIsInvalidMediaTypeObject ( $invalidMediaType ): void {
		$this->assertNull( MediaType::newFromString( $invalidMediaType ) );
	}

	/**
	 * @covers ::getType
	 * @dataProvider provideTypes
	 */
	public function testGetType( $expectedType, $actualType ): void {
		$this->assertEquals(
			$expectedType,
			MediaType::newFromString( $actualType )->getType()
		);
	}

	/**
	 * @covers ::getSubType
	 * @dataProvider provideSubTypes
	 */
	public function testGetSubType( $expectedSubType, $actualSubType ): void {
		$this->assertEquals(
			$expectedSubType,
			MediaType::newFromString( $actualSubType )->getSubType()
		);
	}

	/**
	 * @covers ::getEssence
	 * @dataProvider provideEssences
	 */
	public function testGetEssence( $expectedEssence, $actualEssence ): void {
		$this->assertEquals(
			$expectedEssence,
			MediaType::newFromString( $actualEssence )->getEssence()
		);
	}

	/**
	 * @covers ::getParameters
	 * @dataProvider provideParameters
	 */
	public function testGetParameters( $expectedParameters, $mediaType ): void {
		$this->assertEquals(
			$expectedParameters,
			MediaType::newFromString( $mediaType )->getParameters()
		);
	}

	/**
	 * @covers ::getParameterValue
	 * @dataProvider provideParameterValues
	 */
	public function testGetParameterValue( $expectedParameterValue, $parameterName, $mediaType ): void {
		$this->assertEquals(
			$expectedParameterValue,
			MediaType::newFromString( $mediaType )->getParameterValue( $parameterName )
		);
	}

	/**
	 * @covers ::__toString
	 * @dataProvider provideStrings
	 */
	public function testToString( $expectedString, $mediaType ): void {
		$this->assertEquals(
			$expectedString,
			(string)MediaType::newFromString( $mediaType )
		);
	}

	public function provideValidMediaTypes() {
		return [
			[ 'text/plain;charset=UTF-8' ],
			[ 'application/xhtml+xml' ],
			[ 'application/vnd.openxmlformats-officedocument.presentationml.presentation' ],
			[ '\n\r\t\0\x0Btext/plain\n\r\t\0\x0B' ],
		];
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
				'text/plain',
				'text/plain',
			],
			[
				'application/xhtml+xml',
				'application/xhtml+xml',
			],
			[
				'application/vnd.openxmlformats-officedocument.presentationml.presentation',
				'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			],
		];
	}

	public function provideParameters() {
		return [
			[
				[ 'charset' => 'UTF-8' ],
				'text/plain;charset=UTF-8',
			],
			[
				[],
				'text/plain',
			],
		];
	}

	public function provideParameterValues() {
		return [
			[
				'UTF-8',
				'charset',
				'text/plain;charset=UTF-8',
			],
			[
				null,
				'charset',
				'text/plain',
			]
		];
	}

	public function provideStrings() {
		return [
			[
				'text/input',
				'text/input',
			],
			[
				'text/plain;charset=UTF-8',
				'text/plain;charset=UTF-8',
			],
			[
				'application/vnd.openxmlformats-officedocument.presentationml.presentation',
				'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			]
		];
	}
}
