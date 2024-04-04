<?php

namespace Neoncitylights\MediaType\Sniff;

use Neoncitylights\MediaType\MediaType;

final readonly class SniffAgent {
	/**
	 * https://mimesniff.spec.whatwg.org/#computed-mime-type
	 */
	public MediaType|null $computedMimeType;

	/**
	 * @param MediaType $suppliedMediaType https://mimesniff.spec.whatwg.org/#supplied-mime-type
	 * @param bool $checkForApacheFlag https://mimesniff.spec.whatwg.org/#check-for-apache-bug-flag
	 * @param bool $noSniffFlag https://mimesniff.spec.whatwg.org/#no-sniff-flag
	 */
	public function __construct(
		public MediaType $suppliedMediaType,
		public bool $checkForApacheFlag,
		public bool $noSniffFlag
	) {
		$this->suppliedMediaType = $suppliedMediaType;
		$this->computedMimeType = null;
		$this->checkForApacheFlag = $checkForApacheFlag;
		$this->noSniffFlag = $noSniffFlag;
	}
}
