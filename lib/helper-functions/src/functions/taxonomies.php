<?php
/**
 * Function helpers for using with taxonomies.
 *
 * @package    Helper Functions
 * @subpackage Taxonomies
 * @author     Francisco Giraldo <fgiraldo@wearenolte.com.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wearenolte.com
 * @since      1.0.0
 */

/**
 * Function to get a post's term object from a given taxonomy.
 *
 * @param int    $post_id ID of the post if not specified it will use get_the_ID() to get the ID.
 * @param string $taxonomy the taxonomy to fetch the term, defaults to 'category'.
 * @param int    $index The position of the term to get, by default gets the first one.
 * @return WP_Term The term object or empty string if not found.
 */
function lean_get_post_term( int $post_id = 0, string $taxonomy = 'category', int $index = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();

	$terms = wp_get_post_terms( $post_id, $taxonomy );

	if ( $terms instanceof WP_Error || empty( $terms ) ) {
		return '';
	}

	$term = $terms[ $index ];

	return $term instanceof WP_Term ? $term : '';
}

/**
 * Function to get a post's term name from a given taxonomy.
 *
 * @param int    $post_id ID of the post if not specified it will use get_the_ID() to get the ID.
 * @param string $taxonomy the taxonomy to fetch the term, defaults to 'category'.
 * @param int    $index The position of the term to get, by default gets the first one.
 * @return string The term name or empty string if not found.
 */
function lean_get_post_term_name( int $post_id = 0, string $taxonomy = 'category', int $index = 0 ) {
	$term = lean_get_post_term( $post_id, $taxonomy, $index );
	return $term instanceof WP_Term ? $term->name : '';
}

/**
 * Function to get the posts ids linked to a term ID.
 *
 * @param int    $term_id The id of the term to be used.
 * @param string $taxonomy The category of the term.
 * @param int    $limit The number of posts to get by default only gets one.
 * @return array the posts or empty array.
 */
function lean_get_posts_by_term( int $term_id, string $taxonomy = 'category', int $limit = 20 ) {
	$post_query = new WP_Query([
		'posts_per_page' => $limit,
		'no_found_rows' => true,
		'update_post_meta_cache' => false,
		'fields' => 'ids',
		'tax_query' => [
			[
				'taxonomy' => $taxonomy,
				'field' => 'term_id',
				'terms' => $term_id,
			],
		],
	]);

	return is_object( $post_query ) ? $post_query->posts : [];
}

/**
 * Function to get one post by a term ID.
 *
 * @param int    $term_id The id of the term to be used.
 * @param string $taxonomy The category of the term.
 * @return WP_Post|string the post or empty string.
 */
function lean_get_post_by_term( int $term_id, string $taxonomy = 'category' ) {
	$posts = lean_get_posts_by_term( $term_id, $taxonomy, 1 );
	return empty( $posts ) ? '' : get_post( $posts[0] );
}
