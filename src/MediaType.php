<?php

namespace Neoncitylights\MediaType;

use Stringable;

/**
 * @see https://tools.ietf.org/html/rfc2045
 * @see https://mimesniff.spec.whatwg.org/
 * @license MIT
 */
final class MediaType implements Stringable {
	/**
	 * Gives the first portion of a media type's essence.
	 * e.g, if given 'text/plain', it will return 'text'.
	 *
	 * @see https://mimesniff.spec.whatwg.org/#type
	 * @var string
	 */
	public readonly string $type;

	/**
	 * Gives the second portion of a media type's essence.
	 * e.g, if given 'text/plain', it will return 'plain'.
	 *
	 * @see https://mimesniff.spec.whatwg.org/#subtype
	 * @var string
	 */
	public readonly string $subType;

	/**
	 * Gives an array of parameters of a media type,
	 * if any parameters exist. Otherwise, it will return an empty array.
	 *
	 * @see https://mimesniff.spec.whatwg.org/#parameters
	 * @var string[]
	 */
	public readonly array $parameters;

	/**
	 * @param string $type
	 * @param string $subType
	 * @param string[] $parameters
	 */
	public function __construct( string $type, string $subType, array $parameters ) {
		$this->type = $type;
		$this->subType = $subType;
		$this->parameters = $parameters;
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
		return $this->type === 'image';
	}

	/**
	 * https://mimesniff.spec.whatwg.org/#audio-or-video-mime-type
	 */
	public function isAudioOrVideo(): bool {
		return $this->type === 'video'
			|| $this->type === 'audio'
			|| $this->getEssence() === 'application/ogg';
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#font-mime-type
	 */
	public function isFont(): bool {
		return $this->type === 'font'
			|| ( $this->type === 'application'
			&& \in_array( $this->subType, [
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
		return \str_ends_with( $this->subType, '+zip' )
			|| $this->getEssence() === 'application/zip';
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#archive-mime-type
	 */
	public function isArchive(): bool {
		return $this->type === 'application'
			&& \in_array( $this->subType, [ 'x-rar-compressed', 'zip', 'x-gzip' ] );
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#xml-mime-type
	 */
	public function isXml(): bool {
		return \str_ends_with( $this->subType, '+xml' )
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
				$this->type === 'application'
				&& \in_array( $this->subType, [
					'ecmascript',
					'javascript',
					'x-ecmascript',
					'x-javascript'
				] ) )
			|| (
				$this->type === 'text'
				&& \in_array( $this->subType, [
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
		return \str_ends_with( $this->subType, '+json' )
			|| $this->getEssence() === 'application/json'
			|| $this->getEssence() === 'text/json';
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#minimize-a-supported-mime-type
	 */
	public function minimize( bool $isSupported ): string {
		if ( $this->isJavaScript() ) {
			return 'text/javascript';
		}

		if ( $this->isJson() ) {
			return 'application/json';
		}

		if ( $this->getEssence() === 'image/svg+xml' ) {
			return 'image/svg+xml';
		}

		if ( $this->isXml() ) {
			return 'application/xml';
		}

		if ( $isSupported ) {
			return $this->getEssence();
		}

		return "";
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#serializing-a-mime-type
	 * @return string
	 */
	public function __toString(): string {
		$essence = $this->getEssence();
		if ( $this->parameters === [] ) {
			return $essence;
		}

		$serializedParameters = '';
		foreach ( $this->parameters as $parameter => $value ) {
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
