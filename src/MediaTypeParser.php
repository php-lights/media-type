<?php

namespace Neoncitylights\MediaType;

class MediaTypeParser {
	public function parse( string $s ) {
		$length = strlen( $s );
		$normalized = Utf8Utils::trimHttpWhitespace( $s );
		$position = 0;

		$type = $this->collectType( $normalized, $length, $position );
		$subType = $this->collectSubType( $normalized, $length, $position );
		$parameters = $this->collectParameters( $s, $length, $position );

		return new MediaType( $type, $subType, $parameters );
	}

	private function collectType( string $s, int $length, int &$position ): string {
		$type = Utf8Utils::collectCodePoints(
			$s, $position,
			fn( string $c ) => $c === MediaType::TOKEN_TYPE_SEPARATOR
		);
		if ( $position > $length ) {
			throw new MediaTypeParserException();
		}
		$position++;

		return $type;
	}

	private function collectSubType( string $s, int &$position ): string {
		$subType = Utf8Utils::collectCodePoints(
			$s, $position,
			fn( string $c ) => $c === MediaType::TOKEN_DELIMETER
		);
		$subType = Utf8Utils::trimHttpWhitespace( $subType );
		if ( $subType === '' ) {
			throw new MediaTypeParserException();
		}

		return $subType;
	}

	private function collectParameters( string $s, int $length, int &$position ): array {
		$parameters = [];
		while ( $position < $length ) {
			$position++;

			// skip whitespace
			Utf8Utils::collectCodePoints(
				$s, $position,
				fn( string $c ) => Utf8Utils::isHttpWhitespace( $c )
			);

			// collect parameter name
			$parameterName = Utf8Utils::collectCodePoints(
				$s, $position,
				fn( string $c ) => $c === ';' || $c === '='
			);
			$parameterName = \strtolower( $parameterName );

			// skip parameter delimiters
			if ( $position < $length ) {
				if ( $s[$position] === ';' ) {
					continue;
				}
				$position++;
			}
			if ( $position > $length ) {
				break;
			}

			// collect parameter value
			$parameterValue = null;
			if ( $s[$position] === '"' ) {
				$parameterValue = Utf8Utils::collectCodePoints( $s, $position, fn() => true );
				Utf8Utils::collectCodePoints( $s, $position, fn( string $c ) => $c !== ';' );
			} else {
				$parameterValue = Utf8Utils::collectCodePoints( $s, $position, fn( string $c ) => $c !== ';' );
				$parameterValue = Utf8Utils::trimHttpWhitespace( $parameterValue );
				if ( $parameterValue === '' ) {
					continue;
				}
			}

			// check that parameter name and parameter values are valid
			if (
				$parameterName !== ''
				&& Utf8Utils::onlyContains( $parameterName,
					fn( string $c ) => Utf8Utils::isHttpTokenCodepoint( $c ) )
				&& Utf8Utils::onlyContains( $parameterValue,
					fn( string $c ) => Utf8Utils::isHttpQuotedStringTokenCodepoint( $c ) )
				&& isset( $parameters[$parameterValue] )
			) {
				$parameters[$parameterName] = $parameterValue;
			}
		}

		return $parameters;
	}
}
