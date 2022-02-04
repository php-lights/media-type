<?php

namespace Neoncitylights\MediaType;

/**
 * @see https://tools.ietf.org/html/rfc2045
 * @see https://mimesniff.spec.whatwg.org/
 * @license MIT
 */
class MediaType {
	private const TOKEN_TYPE_SEPARATOR = '/';
	private const TOKEN_DELIMETER = ';';
	private const TOKEN_EQUAL = '=';

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
	 * @param string $input
	 * @return self|null
	 */
	public static function newFromString( string $input ): ?self {
		$trimmedInput = trim( $input );
		if ( empty( $trimmedInput ) ) {
			return null;
		}

		$parts = explode( self::TOKEN_DELIMETER, $trimmedInput );
		list( $type, $subType ) = explode( self::TOKEN_TYPE_SEPARATOR, $parts[0] );
		unset( $parts[0] );

		$parameters = [];
		foreach ( $parts as $part ) {
			$paramParts = explode( self::TOKEN_EQUAL, $part );
			$parameters[$paramParts[0]] = $paramParts[1];
		}

		return new self( $type, $subType, $parameters );
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
		if ( !array_key_exists( $parameterName, $this->parameters ) ) {
			return null;
		}

		return $this->parameters[$parameterName];
	}

	/**
	 * @return string
	 */
	public function __toString(): string {
		$essence = $this->getEssence();
		if ( empty( $this->getParameters() ) ) {
			return $essence;
		}

		$serializedParameters = '';
		foreach ( $this->getParameters() as $parameter => $value ) {
			$serializedParameters .= ";{$parameter}={$value}";
		}

		return "{$essence}{$serializedParameters}";
	}
}
