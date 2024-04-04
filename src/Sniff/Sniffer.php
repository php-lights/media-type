<?php

namespace Neoncitylights\MediaType\Sniff;

use Neoncitylights\MediaType\MediaType;

final class Sniffer {
	/**
	 * Undocumented function
	 *
	 * @param array $tableLookup
	 * @param array $sequence
	 * @return void
	 */
	public function performTableLookup( array $tableLookup, array $sequence ) {
		$imageTable = SniffTableLookup::IMAGE;
		foreach ( $imageTable as $tableRecord ) {
			$lookupValue = new SniffTableValue(
				$tableRecord[0],
				$tableRecord[1],
				$tableRecord[2],
				new MediaType( $tableRecord[3][0], $tableRecord[3][1], [] )
			);

			$patternMatched = $this->doesByteSequenceMatchPattern(
				$sequence,
				$lookupValue->pattern,
				$lookupValue->patternMask,
				$lookupValue->bytesIgnored
			);

			if ( $patternMatched ) {
				return $lookupValue->mediaType;
			}
		}
	}

	private function matchesSignatureForMP4( array $input ) {
		$length = count( $input );
		if ( $length < 12 ) {
			return false;
		}

		$boxSize = \intval( \pack( "L*", ...\array_slice( $input, 0, 4 ) ) );
		if ( $length < $boxSize || $boxSize % 4 !== 0 ) {
			return false;
		}

		$bytes4to7 = \array_slice( $input, 4, 4 );
		if ( $bytes4to7 !== [ 0x66, 0x74, 0x79, 0x70 ] ) {
			return false;
		}

		$bytes8to10 = \array_slice( $input, 8, 3 );
		$mp4Signature = [ 0x6D, 0x70, 0x34 ];
		if ( $bytes8to10 === $mp4Signature ) {
			return true;
		}

		$bytesRead = 16;
		while ( $bytesRead < $boxSize ) {
			$byteSlice = [ $input[$bytesRead], $input[$bytesRead + 1], $input[$bytesRead + 2] ];
			if ( $byteSlice === $mp4Signature ) {
				return true;
			}
			$bytesRead += 4;
		}

		return false;
	}

	private function matchesSignatureForWebM() {
	}

	/**
	 * @see https://mimesniff.spec.whatwg.org/#pattern-matching-algorithm
	 * @param int[] $input
	 * @param int[] $pattern
	 * @param int[] $patternMask
	 * @param int[] $bytesIgnored
	 * @return bool
	 */
	private function doesByteSequenceMatchPattern(
		array $input,
		array $pattern,
		array $patternMask,
		array $bytesIgnored
	): bool {
		$inputLen = count( $input );
		$patternLen = count( $pattern );

		if ( $inputLen < $patternLen ) {
			return false;
		}

		$s = 0;
		while ( $s < $inputLen ) {
			if ( !in_array( $input[$s], $bytesIgnored ) ) {
				return false;
			}
			$s++;
		}

		$p = 0;
		while ( $p < $patternLen ) {
			$maskedData = $input[$s] & $patternMask[$p];
			if ( $maskedData !== $pattern[$p] ) {
				return false;
			}
			$s++;
			$p++;
		}

		return true;
	}
}
