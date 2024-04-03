<?php

namespace Neoncitylights\MediaType\Tests;

use Neoncitylights\MediaType\MediaType;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass( MediaType::class )]
class MediaTypeTest extends TestCase {
	public function testConstructor(): void {
		$this->assertInstanceOf(
			MediaType::class,
			new MediaType( 'text', 'plain', [] )
		);
	}

	#[DataProvider( "provideEssences" )]
	public function testGetEssence( string $type, string $subType, string $expectedEssence ): void {
		$this->assertEquals(
			$expectedEssence,
			( new MediaType( $type, $subType, [] ) )->getEssence()
		);
	}

	#[DataProvider( "provideParameterValues" )]
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

	#[DataProvider( "provideMinimize" )]
	public function testMinimize(
		string $type,
		string $subType,
		string $expectedEssence,
		bool $isSupported,
	) {
		$this->assertEquals(
			$expectedEssence,
			( new MediaType( $type, $subType, [] ) )->minimize( $isSupported )
		);
	}

	#[DataProvider( "provideStrings" )]
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

	public static function provideEssences() {
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

	public static function provideParameters() {
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

	public static function provideParameterValues() {
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

	public static function provideMinimize() {
		return [
			[
				'application',
				'ecmascript',
				'text/javascript',
				true,
			],
			[
				'text',
				'json',
				'application/json',
				true,
			],
			[
				'image',
				'svg+xml',
				'image/svg+xml',
				true,
			],
			[
				'text',
				'xml',
				'application/xml',
				true,
			],
			[
				'text',
				'plain',
				'text/plain',
				true,
			],
			[
				'application',
				'xhtml+xml',
				'application/xml',
				true,
			],
			[
				'application',
				'vnd.openxmlformats-officedocument.presentationml.presentation',
				'application/vnd.openxmlformats-officedocument.presentationml.presentation',
				true,
			],
			[
				'foo',
				'bar',
				'',
				false,
			]
		];
	}

	public static function provideStrings() {
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
