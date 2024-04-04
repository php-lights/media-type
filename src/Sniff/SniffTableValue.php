<?php

namespace Neoncitylights\MediaType\Sniff;

use Neoncitylights\MediaType\MediaType;

final class SniffTableValue {
    /**
     * @see https://mimesniff.spec.whatwg.org/#byte-pattern
     * @var int[]
     */
    public readonly array $pattern;

    /**
     * @see https://mimesniff.spec.whatwg.org/#pattern-mask
     * @var int[]
     */
    public readonly array $patternMask;

    /**
     * @see https://mimesniff.spec.whatwg.org/#bytes-ignored
     * @var int[]
     */
    public readonly array $bytesIgnored;

    public readonly MediaType $mediaType;

    public function __construct(
        array $pattern,
        array $patternMask,
        array $bytesIgnored,
        MediaType $mediaType
    ) {
        $this->pattern = $pattern;
        $this->patternMask = $patternMask;
        $this->bytesIgnored = $bytesIgnored;
        $this->mediaType = $mediaType;
    }
}
