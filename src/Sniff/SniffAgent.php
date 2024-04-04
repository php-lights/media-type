<?php

namespace Neoncitylights\MediaType\Sniff;

use Neoncitylights\MediaType\MediaType;

final class SniffAgent {
	/**
	 * @see https://mimesniff.spec.whatwg.org/#supplied-mime-type
	 */
	public readonly MediaType $suppliedMediaType;

	/**
	 * @see https://mimesniff.spec.whatwg.org/#check-for-apache-bug-flag
	 */
	public readonly bool $checkForApacheFlag;

	/**
	 * @see https://mimesniff.spec.whatwg.org/#no-sniff-flag
	 */
	public readonly bool $noSniffFlag;

	/**
	 * https://mimesniff.spec.whatwg.org/#computed-mime-type
	 */
	public MediaType|null $computedMimeType;

	public function __construct(
		MediaType $suppliedMediaType,
		bool $checkForApacheFlag,
		bool $noSniffFlag
	) {
		$this->suppliedMediaType = $suppliedMediaType;
		$this->computedMimeType = null;
		$this->checkForApacheFlag = $checkForApacheFlag;
		$this->noSniffFlag = $noSniffFlag;
	}
}
