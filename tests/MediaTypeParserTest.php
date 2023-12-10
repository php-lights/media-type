<?php

namespace Neoncitylights\MediaType\Tests;

use Neoncitylights\MediaType\MediaType;
use Neoncitylights\MediaType\MediaTypeParser;
use Neoncitylights\MediaType\MediaTypeParserException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Neoncitylights\MediaType\MediaTypeParser
 */
class MediaTypeParserTest extends TestCase {
	private MediaTypeParser $parser;

	protected function setUp(): void {
		$this->parser = new MediaTypeParser();
	}

	/**
	 * @covers ::parse
	 * @dataProvider provideValidMediaTypes
	 */
	public function testValidMediaTypes(
		string $validMediaType,
		string $expectedType,
		string $expectedSubType,
		array $expectedParameters
	): void {
		$parsedValue = $this->parser->parse( $validMediaType );

		$this->assertInstanceOf( MediaType::class, $parsedValue );
		$this->assertEquals( $expectedType, $parsedValue->getType() );
		$this->assertEquals( $expectedSubType, $parsedValue->getSubType() );
		$this->assertEquals( $expectedParameters, $parsedValue->getParameters() );
	}

	/**
	 * @covers ::parse
	 * @dataProvider provideInvalidMediaTypes
	 */
	public function testInvalidMediaTypes( $invalidMediaType ): void {
		$this->expectException( MediaTypeParserException::class );
		$this->parser->parse( $invalidMediaType );
	}

	public function provideValidMediaTypes(): array {
		return [
			[
				'text/plain',
				'text',
				'plain',
				[],
			],
			[
				'text/plain;charset=UTF-8',
				'text',
				'plain',
				[
					'charset' => 'UTF-8',
				],
			],
			[
				'  text/plain;charset=UTF-8  ',
				'text',
				'plain',
				[
					'charset' => 'UTF-8',
				],
			],
			[
				'  text/plain;   charset=UTF-8  ',
				'text',
				'plain',
				[
					'charset' => 'UTF-8',
				],
			],
			[
				"text/plain;charset=\"UTF-8\"",
				'text',
				'plain',
				[
					'charset' => "UTF-8",
				],
			],
			[
				'TexT/PlAin',
				'text',
				'plain',
				[]
			],
			[
				'text/ plain ',
				'text',
				'plain',
				[],
			],
			[
				'application/vnd.openxmlformats-officedocument.presentationml.presentation',
				'application',
				'vnd.openxmlformats-officedocument.presentationml.presentation',
				[],
			]
		];
	}

	public function provideInvalidMediaTypes(): array {
		return [
			[ '' ],
			[ '    ' ],
			[ '\n\n\n\n\r\r\r' ],
			[ 'text' ],
			[ 'tex\t/plain' ],
			[ 'text/pla\in' ],
			[ '/plain' ],
			[ 'text/' ],
		];
	}
}
