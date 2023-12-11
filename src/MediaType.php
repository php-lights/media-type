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
	 * @see https://mimesniff.spec.whatwg.org/#image-mime-type
	 */
	public function isImage(): bool {
		return $this->getType() === 'image';
	}

	/**
	 * https://mimesniff.spec.whatwg.org/#audio-or-video-mime-type
	 */
	public function isAudioOrVideo(): bool {
		return $this->getType() === 'video'
			|| $this->getType() === 'audio'
			|| $this->getEssence() === 'application/ogg';
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#font-mime-type
	 */
	public function isFont(): bool {
		return $this->getType() === 'font'
			|| ( $this->getType() === 'application'
			&& \in_array( $this->getSubType(), [
				'font-cff',
				'font-off',
				'font-sfnt',
				'font-ttf',
				'font-woff',
				'vnd.ms-fontobject',
				'vnd.ms-opentype ',
			] ) );
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#zip-based-mime-type
	 */
	public function isZipBased(): bool {
		return \str_ends_with( $this->getSubType(), '+zip' )
			|| $this->getEssence() === 'application/zip';
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#archive-mime-type
	 */
	public function isArchive(): bool {
		return $this->getType() === 'application'
			&& \in_array( $this->getSubType(), [ 'x-rar-compressed', 'zip', 'x-gzip' ] );
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#xml-mime-type
	 */
	public function isXml(): bool {
		return \str_ends_with( $this->getSubType(), '+xml' )
			|| $this->getEssence() === 'text/xml'
			|| $this->getEssence() === 'application/xml';
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#html-mime-type
	 *
	 * @return bool
	 */
	public function isHtml(): bool {
		return $this->getEssence() === 'text/html';
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#scriptable-mime-type
	 */
	public function isScriptable(): bool {
		return $this->isXml()
			|| $this->isHtml()
			|| $this->getEssence() === 'application/pdf';
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#javascript-mime-type
	 */
	public function isJavaScript(): bool {
		return (
				$this->getType() === 'application'
				&& \in_array( $this->getSubType(), [
					'ecmascript',
					'javascript',
					'x-ecmascript',
					'x-javascript'
				] ) )
			|| (
				$this->getType() === 'text'
				&& \in_array( $this->getSubType(), [
					'ecmascript',
					'javascript',
					'javascript1.0',
					'javascript1.1',
					'javascript1.2',
					'javascript1.3',
					'javascript1.4',
					'javascript1.5',
					'jscript',
					'livescript',
					'x-ecmascript',
					'x-javascript'
				] ) );
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#json-mime-type
	 */
	public function isJson(): bool {
		return \str_ends_with( $this->getSubType(), '+json' )
			|| $this->getEssence() === 'application/json'
			|| $this->getEssence() === 'text/json';
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
				fn ( string $s ) => Utf8Utils::isHttpTokenCodepoint( $s ) );

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
