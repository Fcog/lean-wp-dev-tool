<?php
/**
 * Function helpers for using with requests.
 *
 * @package    Helper Functions
 * @subpackage Requests
 * @author     Francisco Giraldo <fgiraldo@wearenolte.com.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wearenolte.com
 * @since      1.0.0
 */

/**
 * Gets a sanitized request value. It sanitizes differntly depending on the value type.
 *
 * @param string $key the request key.
 * @param string $type the requested value type.
 * @return string
 */
function lean_request( string $key, string $type ) {
	if ( ! isset( $_REQUEST[ $key ] ) ) {
		return false;
	}

	$value = $_REQUEST[ $key ];

	switch ( $type ) {
		case 'int':
			return (int) wp_unslash( $value );

		case 'email':
			return sanitize_email( wp_unslash( $value ) );

		case 'text':
		default:
			return sanitize_text_field( wp_unslash( $value ) );
	}
}


/**
 * Gets a sanitized text request value.
 * Check sanitization config: https://developer.wordpress.org/reference/functions/sanitize_text_field/
 *
 * @param string $key the request key.
 * @return string
 */
function lean_request_text( string $key ) {
	return lean_request( $key, 'text' );
}

/**
 * Gets a sanitized number request value.
 *
 * @param string $key the request key.
 * @return string
 */
function lean_request_int( string $key ) {
	return lean_request( $key, 'int' );
}

/**
 * Gets a sanitized email request value.
 * Check sanitization config: https://codex.wordpress.org/Function_Reference/sanitize_email
 *
 * @param string $key the request key.
 * @return string
 */
function lean_request_email( string $key ) {
	return lean_request( $key, 'email' );
}

/**
 * Gets a sanitized array from checkboxes request value.
 * Check sanitization config: https://codex.wordpress.org/Function_Reference/sanitize_email
 *
 * @param string $key the request key.
 * @return string
 */
function lean_request_checkboxes( string $key ) {
	if ( ! isset( $_REQUEST[ $key ] ) ) {
		return false;
	}

	if ( is_array( $_REQUEST[ $key ] ) ) {
		$values = [];
		foreach ( $_REQUEST[ $key ] as $value ) {
			$values[] = sanitize_text_field( wp_unslash( $value ) );
		}
		return $values;
	}

	return sanitize_text_field( wp_unslash( $_REQUEST[ $key ] ) );
}
