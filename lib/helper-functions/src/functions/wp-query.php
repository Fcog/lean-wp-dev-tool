<?php
/**
 * Function helpers for using with WP Query.
 *
 * @package    Helper Functions
 * @subpackage WP Query
 * @author     Francisco Giraldo <fgiraldo@wearenolte.com.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wearenolte.com
 * @since      1.0.0
 */

/**
 * Returns the meta query array element for searching a meta data that is saved serialized.
 * Commonly used in data saved by some ACF fields.
 *
 * @param string $value The value to search.
 * @param string $meta_key The meta key.
 * @return array
 */
function lean_meta_query_find_in_serialized( string $value, string $meta_key ) {
	return [
		'key' => $meta_key,
		'value' => 'i:[0-9]+;((s:[0-9]+)|i):(\")*' . $value . '(\")*;',
		'compare' => 'REGEXP',
	];
}
