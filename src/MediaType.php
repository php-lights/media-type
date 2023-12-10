<?php

namespace Neoncitylights\MediaType;

use Stringable;

/**
 * @see https://tools.ietf.org/html/rfc2045
 * @see https://mimesniff.spec.whatwg.org/
 * @license MIT
 */
class MediaType implements Stringable {
	/**
	 * @see https://mimesniff.spec.whatwg.org/#type
	 * @var string
	 */
	private $type;

	/**
	 * @see https://mimesniff.spec.whatwg.org/#subtype
	 * @var string
	 */
	private $subType;

	/**
	 * @see https://mimesniff.spec.whatwg.org/#parameters
	 * @var string[]
	 */
	private $parameters;

	/**
	 * @param string $type
	 * @param string $subType
	 * @param array $parameters
	 */
	public function __construct( string $type, string $subType, array $parameters ) {
		$this->type = $type;
		$this->subType = $subType;
		$this->parameters = $parameters;
	}

	/**
	 * Gives the first portion of a media type's essence.
	 * e.g, if given 'text/plain', it will return 'text'.
	 *
	 * @see https://mimesniff.spec.whatwg.org/#type
	 * @return string
	 */
	public function getType(): string {
		return $this->type;
	}

	/**
	 * Gives the second portion of a media type's essence.
	 * e.g, if given 'text/plain', it will return 'plain'.
	 *
	 * @see https://mimesniff.spec.whatwg.org/#subtype
	 * @return string
	 */
	public function getSubType(): string {
		return $this->subType;
	}

	/**
	 * Gives the type and subtype of a media type.
	 * e.g, if given 'text/plain;charset=UTF-8', it will return 'text/plain'.
	 *
	 * @see https://mimesniff.spec.whatwg.org/#mime-type-essence
	 * @return string
	 */
	public function getEssence(): string {
		return "{$this->type}/{$this->subType}";
	}

	/**
	 * Gives an array of parameters of a media type,
	 * if any parameters exist. Otherwise, it will return an empty array.
	 *
	 * @see https://mimesniff.spec.whatwg.org/#parameters
	 * @return array
	 */
	public function getParameters(): array {
		return $this->parameters;
	}

	/**
	 * Gives the value of a specified parameter of a media type,
	 * if that parameter exists; otherwise, it will return a null value.
	 * e.g, if given a media type of 'text/plain;charset=UTF-8', and the
	 * given parameter is 'charset', it will return 'UTF-8'.
	 *
	 * @param string $parameterName
	 * @return string|null
	 */
	public function getParameterValue( string $parameterName ): ?string {
		if ( !\array_key_exists( $parameterName, $this->parameters ) ) {
			return null;
		}

		return $this->parameters[$parameterName];
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#serializing-a-mime-type
	 * @return string
	 */
	public function __toString(): string {
		$essence = $this->getEssence();
		if ( $this->getParameters() === [] ) {
			return $essence;
		}

		$serializedParameters = '';
		foreach ( $this->getParameters() as $parameter => $value ) {
			$serializedParameters .= ";{$parameter}=";
			$serializedValue = $value;

			$onlyContainsHttpCodepoints = Utf8Utils::onlyContains(
				$value,
				fn( string $s ) => Utf8Utils::isHttpTokenCodepoint( $s ) );

			if ( $value === '' || !$onlyContainsHttpCodepoints ) {
				$serializedValue = $this->serializeParameterValue( $value );
			}

			$serializedParameters .= $serializedValue;
		}

		return "{$essence}{$serializedParameters}";
	}

	private function serializeParameterValue( string $value ): string {
		$charsToEscape = [ '"', '\\' ];
		$escapedChars = [ '\\"', '\\\\' ];
		$replaced = \str_replace( $charsToEscape, $escapedChars, $value );

		return "\"{$replaced}\"";
	}
}
