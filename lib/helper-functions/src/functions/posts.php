<?php
/**
 * Function helpers for using with posts.
 *
 * @package    Helper Functions
 * @subpackage Posts
 * @author     Francisco Giraldo <fgiraldo@wearenolte.com.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wearenolte.com
 * @since      1.0.0
 */

/**
 * Returns the years in the given order on which the posts have been written.
 *
 * @param string $post_type Name of the post type.
 * @param string $order Desc or Asc.
 * @return array
 */
function lean_get_posts_years( string $post_type = 'post', string $order = 'desc' ) {
	$years_string = wp_get_archives([
		'type' => 'yearly',
		'format' => 'custom',
		'post_type' => $post_type,
		'echo' => false,
	]);
	// Just search for digits inside >2015< (example).
	$re = '/>(\d+)</';
	preg_match_all( $re, $years_string, $matches );
	$matches = (array) $matches;
	$years = empty( $matches[1] ) ? [] : $matches[1];

	if ( ! is_array( $years ) ) {
		return [];
	}

	if ( 'desc' === $order ) {
		rsort( $years, SORT_NUMERIC );
	} else {
		sort( $years, SORT_NUMERIC );
	}

	return $years;
}
