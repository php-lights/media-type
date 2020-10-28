<?php

namespace Neoncitylights\MediaType\Tests;

use Neoncitylights\MediaType\MediaType;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Neoncitylights\MediaType\MediaType
 */
class MediaTypeTest extends TestCase {
	/**
	 * @covers ::newFromString
	 * @dataProvider provideValidMediaTypes
	 */
	public function testIsValidMediaType( $validMediaType ) {
		$this->assertInstanceOf( MediaType::class, MediaType::newFromString( $validMediaType ) );
	}

	/**
	 * @covers ::newFromString
	 * @dataProvider provideInvalidMediaTypes
	 */
	public function testIsInvalidMediaTypeObject ( $invalidMediaType ) {
		$this->assertNull( MediaType::newFromString( $invalidMediaType ) );
	}

	/**
	 * @covers ::getType
	 * @dataProvider provideTypes
	 */
	public function testGetType( $expectedType, $actualType ) {
		$this->assertEquals( $expectedType, $actualType );
	}

	/**
	 * @covers ::getSubType
	 * @dataProvider provideSubTypes
	 */
	public function testGetSubType( $expectedSubType, $actualSubType ) {
		$this->assertEquals( $expectedSubType, $actualSubType );
	}

	/**
	 * @covers ::getEssence
	 * @dataProvider provideEssences
	 */
	public function testGetEssence( $expectedEssence, $actualEssence ) {
		$this->assertEquals( $expectedEssence, $actualEssence );
	}

	/**
	 * @covers ::getParameters
	 * @dataProvider provideParameters
	 */
	public function testGetParameters( $expectedParameters, $actualParameters ) {
		$this->assertEquals( $expectedParameters, $actualParameters );
	}

	/**
	 * @covers ::getParameterValue
	 * @dataProvider provideParameterValues
	 */
	public function testGetParameterValue( $expectedParameterValue, $actualParameterValue ) {
		$this->assertEquals( $expectedParameterValue, $actualParameterValue );
	}

	/**
	 * @covers ::__toString
	 * @dataProvider provideStrings
	 */
	public function testToString( $expectedString, $actualString ) {
		$this->assertEquals( $expectedString, $actualString );
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
				MediaType::newFromString( 'text/plain' )->getType(),
			],
			[
				'application',
				MediaType::newFromString( 'application/xhtml+xml' )->getType(),
			],
			[
				'application',
				MediaType::newFromString( 'application/vnd.openxmlformats-officedocument.presentationml.presentation' )->getType(),
			],
		];
	}

	public function provideSubTypes() {
		return [
			[
				'plain',
				MediaType::newFromString( 'text/plain' )->getSubType(),
			],
			[
				'xhtml+xml',
				MediaType::newFromString( 'application/xhtml+xml' )->getSubType(),
			],
			[
				'vnd.openxmlformats-officedocument.presentationml.presentation',
				MediaType::newFromString( 'application/vnd.openxmlformats-officedocument.presentationml.presentation' )->getSubType(),
			],
		];
	}

	public function provideEssences() {
		return [
			[
				'text/plain',
				MediaType::newFromString( 'text/plain' )->getEssence(),
			],
			[
				'application/xhtml+xml',
				MediaType::newFromString( 'application/xhtml+xml' )->getEssence(),
			],
			[
				'application/vnd.openxmlformats-officedocument.presentationml.presentation',
				MediaType::newFromString( 'application/vnd.openxmlformats-officedocument.presentationml.presentation' )->getEssence(),
			],
		];
	}

	public function provideParameters() {
		return [
			[
				[
					'charset' => 'UTF-8'
				],
				MediaType::newFromString( 'text/plain;charset=UTF-8' )->getParameters(),
			],
			[
				[],
				MediaType::newFromString( 'text/plain' )->getParameters(),
			],
		];
	}

	public function provideParameterValues() {
		return [
			[ 
				'UTF-8',
				MediaType::newFromString( 'text/plain;charset=UTF-8' )->getParameterValue( 'charset' ),
			],
			[
				MediaType::newFromString( 'text/plain' )->getParameterValue( 'charset' ),
				null,
			]
		];
	}

	public function provideStrings() {
		return [
			[
				'text/input',
				(string)MediaType::newFromString( 'text/input' ),
			],
			[
				'text/plain;charset=UTF-8',
				(string)MediaType::newFromString( 'text/plain;charset=UTF-8' ),
			],
			[
				'application/vnd.openxmlformats-officedocument.presentationml.presentation',
				(string)MediaType::newFromString( 'application/vnd.openxmlformats-officedocument.presentationml.presentation' ),
			]
		];
	}
}
