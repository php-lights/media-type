<?php

namespace Neoncitylights\MediaType\Tests;

use Neoncitylights\MediaType\MediaType;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass( MediaType::class )]
class MediaTypeMatchesTest extends TestCase {

	#[DataProvider( "provideIsImage" )]
	public function testIsImage( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isImage()
		);
	}

	#[DataProvider( "provideIsAudioOrVideo" )]
	public function testIsAudioOrVideo( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isAudioOrVideo()
		);
	}

	#[DataProvider( "provideIsFont" )]
	public function testIsFont( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isFont()
		);
	}

	#[DataProvider( "provideIsZipBased" )]
	public function testIsZipBased( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isZipBased()
		);
	}

	#[DataProvider( "provideIsArchive" )]
	public function testIsArchive( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isArchive()
		);
	}

	#[DataProvider( "provideIsXml" )]
	public function testIsXml( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isXml()
		);
	}

	#[DataProvider( "provideIsHtml" )]
	public function testIsHtml( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isHtml()
		);
	}

	#[DataProvider( "provideIsXml" )]
	#[DataProvider( "provideIsHtml" )]
	#[DataProvider( "provideIsScriptable" )]
	public function testIsScriptable( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isScriptable()
		);
	}

	#[DataProvider( "provideIsJavaScript" )]
	public function testIsJavaScript( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isJavaScript()
		);
	}

	#[DataProvider( "provideIsJson" )]
	public function testIsJson( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isJson()
		);
	}

	public static function provideIsImage(): array {
		return [
			[ 'image', 'png', true ],
			[ 'image', 'jpeg', true ],
			[ 'text', 'plain', false ],
		];
	}

	public static function provideIsAudioOrVideo(): array {
		return [
			[ 'audio', 'mpeg', true ],
			[ 'video', 'mp4', true ],
			[ 'text', 'plain', false ],
		];
	}

	public static function provideIsFont(): array {
		return [
			[ 'font', 'woff', true ],
			[ 'font', 'woff2', true ],
			[ 'text', 'plain', false ],
		];
	}

	public static function provideIsZipBased(): array {
		return [
			[ 'application', 'zip', true ],
			[ 'application', 'automationml-amlx+zip', true ],
			[ 'application', 'bacnet-xdd+zip', true ],
			[ 'text', 'plain', false ],
		];
	}

	public static function provideIsArchive(): array {
		return [
			[ 'application', 'zip', true ],
			[ 'application', 'x-rar-compressed', true ],
			[ 'text', 'plain', false ],
		];
	}

	public static function provideIsXml(): array {
		return [
			[ 'application', 'xml', true ],
			[ 'application', 'atom+xml', true ],
			[ 'application', 'calendar+xml', true ],
			[ 'application', 'xslt+xml', true ],
			[ 'text', 'xml', true ],
			[ 'text', 'plain', false ],
		];
	}

	public static function provideIsHtml(): array {
		return [
			[ 'text', 'html', true ],
			[ 'text', 'plain', false ],
		];
	}

	public static function provideIsScriptable(): array {
		return [
			[ 'application', 'pdf', true ],
		];
	}

	public static function provideIsJavaScript(): array {
		return [
			[ 'application', 'ecmascript', true ],
			[ 'application', 'javascript', true ],
			[ 'application', 'x-javascript', true ],
			[ 'application', 'x-ecmascript', true ],
			[ 'text', 'javascript', true ],
			[ 'text', 'ecmascript', true ],
			[ 'text', 'x-javascript', true ],
			[ 'text', 'x-ecmascript', true ],
			[ 'text', 'plain', false ],
		];
	}

	public static function provideIsJson(): array {
		return [
			[ 'application', 'json', true ],
			[ 'model', 'gltf+json', true ],
			[ 'text', 'json', true ],
			[ 'text', 'plain', false ],
		];
	}
}
