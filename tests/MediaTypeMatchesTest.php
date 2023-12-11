<?php

namespace Neoncitylights\MediaType\Tests;

use Neoncitylights\MediaType\MediaType;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Neoncitylights\MediaType\MediaType
 */
class MediaTypeMatchesTest extends TestCase {
	/**
	 * @covers ::isImage
	 * @dataProvider provideIsImage
	 */
	public function testIsImage( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isImage()
		);
	}

	/**
	 * @covers ::isAudioOrVideo
	 * @dataProvider provideIsAudioOrVideo
	 */
	public function testIsAudioOrVideo( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isAudioOrVideo()
		);
	}

	/**
	 * @covers ::isFont
	 * @dataProvider provideIsFont
	 */
	public function testIsFont( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isFont()
		);
	}

	/**
	 * @covers ::isZipBased
	 * @dataProvider provideIsZipBased
	 */
	public function testIsZipBased( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isZipBased()
		);
	}

	/**
	 * @covers ::isArchive
	 * @dataProvider provideIsArchive
	 */
	public function testIsArchive( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isArchive()
		);
	}

	/**
	 * @covers ::isXml
	 * @dataProvider provideIsXml
	 */
	public function testIsXml( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isXml()
		);
	}

	/**
	 * @covers ::isHtml
	 * @dataProvider provideIsHtml
	 */
	public function testIsHtml( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isHtml()
		);
	}

	/**
	 * @covers ::isScriptable
	 * @dataProvider provideIsXml
	 * @dataProvider provideIsHtml
	 * @dataProvider provideIsScriptable
	 */
	public function testIsScriptable( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isScriptable()
		);
	}

	/**
	 * @covers ::isJavaScript
	 * @dataProvider provideIsJavaScript
	 */
	public function testIsJavaScript( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isJavaScript()
		);
	}

	/**
	 * @covers ::isJson
	 * @dataProvider provideIsJson
	 */
	public function testIsJson( string $type, string $subType, bool $expected ): void {
		$mediaType = new MediaType( $type, $subType, [] );
		$this->assertEquals(
			$expected,
			$mediaType->isJson()
		);
	}

	public function provideIsImage(): array {
		return [
			[ 'image', 'png', true ],
			[ 'image', 'jpeg', true ],
			[ 'text', 'plain', false ],
		];
	}

	public function provideIsAudioOrVideo(): array {
		return [
			[ 'audio', 'mpeg', true ],
			[ 'video', 'mp4', true ],
			[ 'text', 'plain', false ],
		];
	}

	public function provideIsFont(): array {
		return [
			[ 'font', 'woff', true ],
			[ 'font', 'woff2', true ],
			[ 'text', 'plain', false ],
		];
	}

	public function provideIsZipBased(): array {
		return [
			[ 'application', 'zip', true ],
			[ 'application', 'automationml-amlx+zip', true ],
			[ 'application', 'bacnet-xdd+zip', true ],
			[ 'text', 'plain', false ],
		];
	}

	public function provideIsArchive(): array {
		return [
			[ 'application', 'zip', true ],
			[ 'application', 'x-rar-compressed', true ],
			[ 'text', 'plain', false ],
		];
	}

	public function provideIsXml(): array {
		return [
			[ 'application', 'xml', true ],
			[ 'application', 'atom+xml', true ],
			[ 'application', 'calendar+xml', true ],
			[ 'application', 'xslt+xml', true ],
			[ 'text', 'xml', true ],
			[ 'text', 'plain', false ],
		];
	}

	public function provideIsHtml(): array {
		return [
			[ 'text', 'html', true ],
			[ 'text', 'plain', false ],
		];
	}

	public function provideIsScriptable(): array {
		return [
			[ 'application', 'pdf', true ],
		];
	}

	public function provideIsJavaScript(): array {
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

	public function provideIsJson(): array {
		return [
			[ 'application', 'json', true ],
			[ 'model', 'gltf+json', true ],
			[ 'text', 'json', true ],
			[ 'text', 'plain', false ],
		];
	}
}
