<?php

namespace Neoncitylights\MediaType\Tests;

use Neoncitylights\MediaType\Token;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
class TokenTest extends TestCase {
	public function testEnumMemberValues(): void {
		$this->assertEquals( ';', Token::Semicolon->value );
		$this->assertEquals( '=', Token::Equal->value );
		$this->assertEquals( '/', Token::Slash->value );
	}
}
