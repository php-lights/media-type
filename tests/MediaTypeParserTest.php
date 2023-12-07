<?php

namespace Neoncitylights\MediaType\Tests;

use Neoncitylights\MediaType\MediaTypeParser;
use Neoncitylights\MediaType\MediaTypeParserException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Neoncitylights\MediaType\MediaTypeParser
 */
class MediaTypeTest extends TestCase {
    /**
     * @covers ::__construct
     */
    public function testConstructor() {
        $this->assertInstanceOf(
            MediaTypeParser::class,
            new MediaTypeParser()
        );
    }
}
