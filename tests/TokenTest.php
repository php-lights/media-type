<?php

namespace Neoncitylights\MediaType\Tests;

use Neoncitylights\MediaType\Token;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Neoncitylights\MediaType\Token
 */
class TokenTest extends TestCase {
	/**
	 * @coversNothing
	 */
	public function testEnumMemberValues(): void {
		$this->assertEquals( ';', Token::Semicolon->value );
		$this->assertEquals( '=', Token::Equal->value );
		$this->assertEquals( '/', Token::Slash->value );
	}
}
