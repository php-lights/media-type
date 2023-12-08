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
	public function testGetEssence(  string $type, string $subType, string $expectedEssence ): void {
		$this->assertEquals(
			$expectedEssence,
			( new MediaType( $type, $subType, [] ) )->getEssence()
		);
	}

	// /**
	//  * @covers ::getParameters
	//  * @dataProvider provideParameters
	//  */
	// public function testGetParameters( $expectedParameters, $mediaType ): void {
	// 	$this->assertEquals(
	// 		$expectedParameters,
	// 		MediaType::newFromString( $mediaType )->getParameters()
	// 	);
	// }

	// /**
	//  * @covers ::getParameterValue
	//  * @dataProvider provideParameterValues
	//  */
	// public function testGetParameterValue( $expectedParameterValue, $parameterName, $mediaType ): void {
	// 	$this->assertEquals(
	// 		$expectedParameterValue,
	// 		MediaType::newFromString( $mediaType )->getParameterValue( $parameterName )
	// 	);
	// }

	// /**
	//  * @covers ::__toString
	//  * @dataProvider provideStrings
	//  */
	// public function testToString( $expectedString, $mediaType ): void {
	// 	$this->assertEquals(
	// 		$expectedString,
	// 		(string)MediaType::newFromString( $mediaType )
	// 	);
	// }

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
