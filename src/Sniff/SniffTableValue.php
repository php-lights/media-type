<?php

namespace Neoncitylights\MediaType\Sniff;

use Neoncitylights\MediaType\MediaType;

final readonly class SniffTableValue {
	/**
	 * @param int[] $pattern https://mimesniff.spec.whatwg.org/#byte-pattern
	 * @param int[] $patternMask https://mimesniff.spec.whatwg.org/#pattern-mask
	 * @param int[] $bytesIgnored https://mimesniff.spec.whatwg.org/#bytes-ignored
	 * @param MediaType $mediaType
	 */
	public function __construct(
		public array $pattern,
		public array $patternMask,
		public array $bytesIgnored,
		public MediaType $mediaType
	) {
		$this->pattern = $pattern;
		$this->patternMask = $patternMask;
		$this->bytesIgnored = $bytesIgnored;
		$this->mediaType = $mediaType;
	}
}
